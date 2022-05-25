<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Intervention\Image\Facades\Image;

class Functions extends Model {
	//
	public static function deleteImage( $name ) {
		$deletepath = base_path( $name );
		if ( file_exists( $deletepath ) and $name != '' ) {
			unlink( $deletepath );
		}

		return true;
	}

	public static function addImage($image,$id,$path) {
		$path_thumb=$path .'thumb_';
		$name = time() . '' . rand( 11111, 99999 ) . '.' . $image->getClientOriginalExtension();
		$img  = Image::make( $image );

		$img->save( $path . $name );

		$img->widen( 200, null );

		$img->save($path_thumb . $name );
		$addImage              = new Images;
		$addImage->image       = $path . $name;
		$addImage->image_thumb = $path_thumb . $name;
		$addImage->unit_id     = $id;
		$addImage->save();
	}
}
