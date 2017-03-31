<?php

namespace App\Importers\Importer;

use App\Exceptions\ImportException;
use App\Exceptions\VendrediException;

abstract class BaseImporter
{
    protected $fields;
    private $importFieldsToColNumber;

    public function __construct()
    {
        $this->setFields();
    }

    /**
     * Sets the CSV columns, in order.
     *
     * @return mixed
     */
    protected abstract function setFields();

    /**
     * Extract a single CSV row into the database.
     *
     * @param $row
     * @param $lineNumber
     */
    protected abstract function extractRow( $row, $lineNumber );

    /**
     * Checks if the row has only falsy values.
     *
     * @param $row
     *
     * @return bool
     */
    protected function isRowEmpty( $row )
    {
        foreach ( $row as $item ) {
            if ( $item ) {
                return false;
            }
        }

        return true;
    }

    /**
     * Returns the value of an imported column of a given row.
     *
     * @param $row
     * @param $colName
     *
     * @return string
     */
    protected function getRowValue( $row, $colName )
    {
        $value = $row[ $this->getImportFieldToColNumber( $colName ) ];

        return $value === '' ? null : $value;
    }

    /**
     * Extract a CSV file into the database.
     *
     * @param \SplFileObject $file
     *
     * @throws ImportException
     * @return int
     */
    public function importFile( $file )
    {
        $isHeader = true;

        $rowCount = - 1;
        while ( ! $file->eof() ) {
            $row = $file->fgetcsv();

            if ( $this->isRowEmpty( $row ) ) {
                continue;
            }

            $rowCount ++;

            if ( $isHeader ) {
                $isHeader = false;
                // remove leading BOM if exists
                $row[0] = str_replace( "\xEF\xBB\xBF", '', $row[0] );


                if ( ! $this->areAllExpectedFieldsPresentInRow( $row ) ) {
                    throw new ImportException( "Les champs du fichier doivent inclure:" . $this->getDisplayImportFields() );
                }

                foreach ( $row as $index => $headerValue ) {
                    $this->importFieldsToColNumber[$headerValue] = $index;
                }

                continue;
            }

            \DB::beginTransaction();
            $this->extractRow( $row, $rowCount + 1 );
            \DB::commit();
        }

        return $rowCount;
    }

    /**
     * Check whether all the fields labels registered in the importer are listed in the header row
     *
     * @param $headerRow
     *
     * @return bool
     */
    private function areAllExpectedFieldsPresentInRow( $headerRow )
    {
        foreach ( $this->fields as $field ) {
            if ( ! in_array( $field, $headerRow ) ) {
                return false;
            }
        }

        return true;
    }

    private function getDisplayImportFields()
    {
        return '<ul><li>' . implode( "<li>", $this->fields ) . '</li></ul>';
    }

    public function getFields()
    {
        return $this->fields;
    }

    /**
     * During an import, get the col number from the column name
     *
     * @param $importFieldName
     *
     * @throws VendrediException
     *
     * @return string
     */
    public function getImportFieldToColNumber( $importFieldName )
    {
        // fill importFields array if empty
        if ( ! $this->importFieldsToColNumber ) {
            throw new VendrediException( 'Something went wrong during the import, contact an admin (trying to access the column number before attribution)' );
        }

        if ( ! isset( $this->importFieldsToColNumber[ $importFieldName ] ) ) {
            // don't catch that error, something went wrong here
            throw new VendrediException( 'Something went wrong, this column name does not exist: ' . $importFieldName );
        }

        return $this->importFieldsToColNumber[ $importFieldName ];
    }
}