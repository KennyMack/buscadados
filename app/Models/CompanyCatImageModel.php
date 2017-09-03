<?php
/**
 * Created by PhpStorm.
 * User: Jonathan
 * Date: 02/09/2017
 * Time: 16:35
 */

namespace App\Models;


use App\CompanyCatImage;
use App\ImageCatTemp;
use App\Utils\ImageContent;

class CompanyCatImageModel
{
    public static function saveImagesCategory($images, $idCompany, $idCompanyCategory)
    {
        $imgPath = public_path('images/company/category/');
        $imgUrl = asset('images/company/category/');

        foreach ($images as $image)
        {
            if ($image != '' && $image != null )
            {
                $idFile = uniqid();

                if (!is_dir($imgPath . $idFile))
                    mkdir($imgPath . $idFile, 0777, true);

                $imgOrigPath = ImageContent::saveImageFromBase64($imgPath . '/'. $idFile . '/', $image, $idFile);

                $extension = explode('.', $imgOrigPath)[1];

                $imgOrigUrl = $imgUrl . '/' . $idFile . '/' . $idFile . '.' . $extension;

                $catimage = new CompanyCatImage();
                $catimage->company_id = $idCompany;
                $catimage->company_category_id = $idCompanyCategory;
                $catimage->imagepath = $imgOrigPath;
                $catimage->imageurl = $imgOrigUrl;

                $catimage->save();
            }
        }
    }

    public static function deleteImagesCategory($deletedImages, $idCompany, $idCompanyCategory)
    {
        foreach ($deletedImages as $id)
        {
            $catImg = CompanyCatImage::find($id);
            if ($catImg != null) {
                if ($catImg->company_category_id == $idCompanyCategory &&
                    $catImg->company_id == $idCompany) {


                    $expfolder = explode('/', $catImg->imagepath);
                    $filefolder = implode('/', array_slice($expfolder, 0, count($expfolder) - 1));

                    \File::delete($catImg->imagepath);
                    \File::deleteDirectory($filefolder);


                    $catImg->delete();
                }
            }
        }
    }

    public static function clearTempImages()
    {
        $session_id = \Session::getId();


        $images = ImageCatTemp::where('session_id', $session_id)->get();


        foreach ($images as $image)
        {
            $image->delete();
        }
    }

    public static function getTempImages()
    {
        $session_id = \Session::getId();

        return ImageCatTemp::where('session_id', $session_id)->get();
    }

}