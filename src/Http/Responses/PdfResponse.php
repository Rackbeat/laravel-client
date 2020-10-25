<?php

namespace RackbeatSDK\Http\Responses;

use Illuminate\Contracts\Support\Responsable;
use Illuminate\Http\Response;

class PdfResponse implements \Stringable, Responsable
{
	protected string $content;

	public function __construct( string $content )
	{
		$this->content = $content;
	}

	public function getContent(): string
	{
		return $this->content;
	}

	/** @inheritDoc */
	public function __toString()
	{
		return $this->content;
	}

	/**
	 * @inheritDoc
	 */
	public function toResponse( $request )
	{
		return new Response( $this->content, 200, [ 'Content-Type' => 'application/pdf' ] );
	}
}