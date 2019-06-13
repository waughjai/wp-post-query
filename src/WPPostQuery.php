<?php

declare( strict_types = 1 );
namespace WaughJ\WPPostQuery;

use WP_Query;

class WPPostQuery
{
	public function __construct( array $args = [] )
	{
		$this->query = new WP_Query( $args );
	}

	public function getQueryContent( callable $function ) : array
	{
		$content = [];
		if ( $this->query->have_posts() )
		{
			while ( $this->query->have_posts() )
			{
				$this->query->the_post();
				array_push( $content, call_user_func( $function ) );
			}
			wp_reset_postdata();
		}
		return $content;
	}

	public function printQueryContent( callable $function ) : void
	{
		$content = $this->getQueryContent( $function );
		foreach ( $content as $content_item )
		{
			echo $content_item;
		}
	}

	private $query;
}
