<?php

namespace Helpers;


use App\Exceptions\VendrediException;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\ClientException;
use Eventviva\ImageResize;
use GuzzleHttp\Exception\ConnectException;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\MessageBag;

class AppHelper
{
    const FLASH_ERROR_VENDREDI = 'errors-vendredi';
    const FLASH_SUCCESS_VENDREDI = 'success-vendredi';

    /**
     * Builds the url to a file uploaded on S3.
     *
     * @param $path
     *
     * @return string
     */
    public function getS3Url( $path )
    {
        $region = Config::get( 'filesystems.disks.s3.region' );
        $bucket = Config::get( 'filesystems.disks.s3.bucket' );

        return "https://s3.${region}.amazonaws.com/${bucket}/${path}";
    }

    /**
     * Convert the image: store it using the filesystem, then save the path to database. If we're not passed an image,
     * do nothing and return the value.
     *
     * @param $imageString : the string value of the image
     * @param $destinationPath : the directory path where to store the image on S3
     *
     * @return string: the path to the uploaded file
     */
    private function savePictureToS3( $imageString, $destinationPath )
    {
        $disk = 's3';

        // 0. Make the image
        $image = \Image::make( $imageString );
        // 1. Generate a filename.
        $filename = md5( $imageString . time() . rand(0, 100)) . '.jpg';
        // 2. Store the image on disk.
        \Storage::disk( $disk )->put( $destinationPath . '/' . $filename, (string) $image->stream() );

        // 3. Save the path to the database
        return $destinationPath . '/' . $filename;
    }

    /**
     * Get the image as a string, resize it to the desired dimensions and compress it in jpeg, upload it to S3.
     *
     * @param $width
     * @param $height
     * @param $imageString
     * @param $destinationPath: filename to use to save the image on S3
     *
     * @return string: path of the uploaded file
     */
    public function resizeAndUploadToS3($width, $height, $imageString, $destinationPath)
    {
        $isPictureString = starts_with( $imageString, 'data:image' );
        if ( ! $isPictureString) {
            return $imageString;
        }

        $prefix = 'data:image/png;base64,';
        $base64 = substr($imageString, strlen($prefix));

        $image = ImageResize::createFromString(base64_decode($base64));

        // resize the image
        if ($height && $width) {
            $image->resize($width, $height);
        }
        elseif ($height) {
            $image->resizeToHeight($height);
        }
        elseif ($width) {
            $image->resizeToWidth($width);
        }
        $image->quality_jpg = 100;

        $imageString = $image->getImageAsString(IMAGETYPE_JPEG);

        return $this->savePictureToS3( $imageString, $destinationPath );
    }

    /**
     * Add a flash message to the current session.
     *
     * @param $flashType
     * @param $message
     */
    public function addFlashMsg( $flashType, $message )
    {
        $messageBag = \Session::get( $flashType, new MessageBag() );
        $messageBag->add( 'default', $message );
        \Session::flash( $flashType, $messageBag );
    }

    /**
     * Modify the query to filter by a join column if the argument is in the reauest.
     *
     * @param \Illuminate\Database\Query\Builder $query
     * @param                                    $joinTableName : the join table to filter on
     * @param array $ids : array of ids to select
     */
    public function addJoinFilterIdsToQuery( $query, $joinTableName, $ids )
    {
        //sanitize
        $ids = array_map(
          function ( $id ) {
              return (int)$id;
          },
          $ids
        );

        if (count( $ids ) !== 0) {
            $query->whereIn( $joinTableName . '.id', $ids );
        }
    }

    /**
     * Modify the query to filter by tokenized search on all specified search fields.
     *
     * @param \Illuminate\Database\Query\Builder $query
     * @param array $searchFieldNames : array of column names to search on (['jobs.name',  ...])
     * @param                                    $searchQuery
     */
    public function addSearchToQuery( $query, $searchFieldNames, $searchQuery )
    {
        if ($searchQuery !== null && $searchQuery !== '') {
            // tokenize
            $searchTokens = preg_split( '~\s+~', $searchQuery );

            // apply filter for each token
            foreach ($searchTokens as $searchToken) {
                $likeToken = '%' . $searchToken . '%';
                $query->where( function ( $query ) use ( $likeToken, $searchFieldNames ) {
                    foreach ($searchFieldNames as $toSearchField) {
                        $query->orWhere(
                          $toSearchField,
                          'LIKE',
                           $likeToken
                        );
                    }
                } );
            }
        }
    }

    /**
     * Creates a custom two letters unique id for the entity, based on its name. (ex: '2Spark' -> 'SP')
     *
     * @param array $vendrediIds : the already existing IDs
     * @param       $name : of the entity
     *
     * @return string
     * @throws VendrediException
     */
    public function getShortVendrediId( $vendrediIds, $name )
    {
        $name = strtoupper( preg_replace( '~\W+~', '', $name ) );

        // augment name length to be sure to have enough to deduplicate
        $name .= 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';

        // try all combinations that preserve the order of letters until we find a unique one
        for ( $i = 0; $i < strlen( $name ); $i ++ ) {
            for ( $j = $i + 1; $j < strlen( $name ); $j ++ ) {
                $id = $name[ $i ] . $name[ $j ];
                if ( ! in_array( $id, $vendrediIds ) ) {
                    return $id;
                }
            }
        }

        // this should never be reached
        throw new VendrediException( 'Could not generate a unique ID.' );
    }

    /**
     * Returns the generated vendredi ID.
     * Example: Job in 2017 for company with vendredi ID 'SP', there are already 10 jobs for that (year, company)
     * will result in '17SP11'
     *
     * @param $date : '2016-01-01'
     * @param $parentId : company's ID
     * @param $parentClass : 'App\Company'
     * @param $childClass : 'App\Job'
     * @param $dateField : 'start_date'
     * @param $parentIdField : 'company_id'
     *
     * @return string
     * @throws VendrediException
     */
    public function getLongVendrediId( $date, $parentId, $parentClass, $childClass, $dateField, $parentIdField )
    {
        $parent = $parentClass::find( $parentId );
        if ( ! $parent ) {
            throw new VendrediException( 'The parent does not exist.' );
        }
        $parentVendrediId = $parent->vendredi_id;

        $year = substr( $date, 0, 4 );
        if ( ! is_numeric( $year ) ) {
            throw new VendrediException( 'Invalid date.' );
        }

        $childrenCount = $childClass::where( $parentIdField, '=', $parentId )
                                    ->where( $dateField, '>=', $year . '-01-01' )
                                    ->where( $dateField, '<', ( (int) $year + 1 ) . '-01-01' )
                                    ->count();

        return substr( $year, 2, 2 ) . $parentVendrediId . sprintf( '%02d', $childrenCount + 1 );
    }

    /**
     * Download the target of a URL, returns the md5 hash. If there is an error (http code 500, timeout...),
     * returns null.
     *
     * @param $url
     *
     * @return string
     */
    public function getUrlFingerprint( $url )
    {
        $client = new Client( [ 'timetout' => 10 ] );

        try {
            $response = $client->get( $url );
            $body = (string) $response->getBody();

            return md5( $body );
        } catch ( ClientException $exception ) {
            $this->addFlashMsg( static::FLASH_ERROR_VENDREDI, $exception->getMessage() );

            return null;
        } catch ( ConnectException $exception ) {
            $this->addFlashMsg( static::FLASH_ERROR_VENDREDI, $exception->getMessage() );

            return null;
        }
    }

    /*
     * Returns "string" if the link is a PDF link that should be displayed on the website (true)
     * or false if we should redirect the user to a new page
     *
     * @return string|boolean
     */
    public function getPdfPreviewLink( $link )
    {
        $results = [];
        if (preg_match( '~drive.google.com/open\?id=([\w-]*)~', $link, $results )) {
            return "https://drive.google.com/file/d/" . $results[1] . "/preview";
        } else if (preg_match( '~drive.google.com/file/d/([\w-]*)~', $link, $results )) {

            return "https://drive.google.com/file/d/" . $results[1] . "/preview";
        }

        return false;
    }

    /*
     * Returns true if the link is a PDF link that should be displayed on the website (true)
     * or false if we should redirect the user to a new page
     *
     * @return string|boolean
     */
    public function isExternalLink( $link )
    {

        // If preview link is a string => localLink
        // If preview link is == false => externalLink
        return $this->getPdfPreviewLink($link) === false ;
    }
}