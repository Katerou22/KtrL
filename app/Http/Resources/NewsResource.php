<?php

	namespace App\Http\Resources;

	use Carbon\Carbon;
	use Illuminate\Http\Resources\Json\JsonResource;

	class NewsResource extends JsonResource {
		/**
		 * Transform the resource into an array.
		 *
		 * @param  \Illuminate\Http\Request $request
		 *
		 * @return array
		 */
		public function toArray($request) {
			return [
				'source'      => $this->source->name,
				'author'      => $this->author,
				'title'       => $this->title,
				'description' => $this->description,
				'image'       => $this->urlToImage,
				'url'         => $this->url,
				'publishedAt' => Carbon::parse($this->publishedAt)->timestamp,
				'content'     => $this->content,
			];
		}
	}
