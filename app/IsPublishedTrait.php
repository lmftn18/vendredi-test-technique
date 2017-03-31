<?php

namespace App;

use Moment\Moment;

trait IsPublishedTrait
{
    public function getIsPublishedAttribute()
    {
        return $this->published_at !== null;
    }

    /**
     * This is how we should toggle the 'published' state.
     *
     * Changes the status of the job to (un)published: sets time of first publication, of latest publication and
     * unpublication, updates the number of days spent in "published" state.
     *
     * @param boolean $value
     */
    public function setIsPublishedAttribute($value)
    {
        $now = new \DateTime();

        if ($value) {
            $this->first_published_at = $this->first_published_at ?: $now;

            // only set publication date if it is a change in publication status
            $this->published_at = $this->published_at ?: $now;
            $this->unpublished_at = null;
        }
        else {
            $daysPublished = $this->days_published ?? 0;
            $this->days_published = $daysPublished + $this->getDaysPublishedCurrentStreak();

            $this->published_at = null;
            // only set unpublication date if it is a change in publication status
            $this->unpublished_at = $this->unpublished_at ?: $now;
        }
    }

    /**
     * Returns the number of days the job has spent in the "published" status:
     * stored number of days spent + current timediff between now and the last publication date
     *
     * @return int
     */
    public function getTotalDaysPublishedAttribute()
    {
        return ( $this->days_published ?? 0 ) + $this->getDaysPublishedCurrentStreak();
    }

    /**
     * Return the time spent in the published status since it was last published.
     *
     * @return int
     */
    private function getDaysPublishedCurrentStreak()
    {
        if ( $this->published_at === null ) {
            return 0;
        }

        $publishedAtString =  ($this->published_at instanceof \DateTime)
            ? $this->published_at->format('Y-m-d')
            : $this->published_at
        ;

        $publishedAt = new Moment( $publishedAtString );
        return abs( (int) $publishedAt->fromNow()->getDays() );
    }
}