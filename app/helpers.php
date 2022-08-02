<?php

use Illuminate\Support\Facades\Route;

if (!function_exists('getImage')) {
    function getImage($details)
    {
        if ($details == null)
            return asset('img/figure/parents.jpg');
        if ($details->user == null)
            return asset('img/figure/parents.jpg');
        $asset = 'storage/photos/'.$details->user->id.'/'.$details->image;
        if (file_exists(public_path($asset)))
            return asset($asset);
        else
            return asset('img/figure/parents.jpg');
    }
}

if (!function_exists('getCV')) {
    function getCV($details)
    {
        
        if ($details == null)
            return asset('img/figure/parents.jpg');
        if ($details->user == null)
            return asset('img/figure/parents.jpg');
        $asset = 'storage/cv/'.$details->user->id.'/'.$details->cv;
        if (file_exists(public_path($asset)))
            return asset($asset);
        else
            return asset('img/figure/parents.jpg');
    }
}

if (!function_exists('currentUserIs')) {
    function currentUserIs($profiles)
    {
        if (auth()->user() == null)
            return true;
        foreach ($profiles as $profile){
            if (auth()->user()->profile === $profile)
                return true;
        }
        return false;
    }
}

if (!function_exists('currentRoute')) {
    function currentRoute($route)
    {
        return str_starts_with(Route::currentRouteName(), $route);
    }
}

if (!function_exists('menuOpen')) {
    function menuOpen($children)
    {
        foreach($children as $child)
            if (currentRoute($child['route']))
                return true;
        return false;
    }
}

if (!function_exists('formatDate')) {
    function formatDate($date)
    {
        return ucfirst(utf8_encode ($date->formatLocalized('%d/%m/%Y')));
    }
}

if (!function_exists('getIDNomArray')) {
    function getIDNomArray($objects)
    {
        $data = [];
        foreach($objects as $obj) $data += [$obj->id => $obj->nom];
        return $data;
    }
}

if (!function_exists('getIDAffichageArray')) {
    function getIDAffichageArray($objects)
    {
        $data = [];
        foreach($objects as $obj) $data += [$obj->id => $obj->affichage()];
        return $data;
    }
}


if (!function_exists('isAssociative')) {
    function isAssociative(array $arr)
    {
        if (array() === $arr) return false;
        return array_keys($arr) !== range(0, count($arr) - 1);
    }
}

if (!function_exists('getDays')) {
    function getDays()
    {
        return [1 => __('Monday'), 2 => __('Tuesday'), 3 => __('Wednesday'), 4 => __('Thirsday'), 5 => __('Friday'), 6 => __('Saturday')];
    }
}

if (!function_exists('inputFormatDate')) {
    function inputFormatDate($date)
    {
        $vals = explode('/', $date);
        return $vals[2].'-'.$vals[1].'-'.$vals[0];
    }
}

if (!function_exists('classeEnseignant')) {
    function classeEnseignant($classe, $id)
    {
        if ($classe == null) return false;
        foreach ($classe->modules ?? [] as $module) {
            foreach ($module->matieres ?? [] as $matiere) {
                if ($matiere->enseignant_id === $id)
                    return true;
            }
        }
        return false;
    }
}

if (!function_exists('getPercent')) {
    function getPercent($value, $total, $showPercent = true)
    {
        $percent = number_format($total == 0 ? 0 : $value * 100 / $total, 2);
        return $showPercent ? $percent.'%' : $percent;
    }
}

if (!function_exists('getMonthShort')) {
    function getMonthShort($month)
    {
        switch ($month) {
            case 1:
                return __('Jan');
            case 2:
                return __('Feb');
            case 3:
                return __('Mar');
            case 4:
                return __('Apr');
            case 5:
                return __('May');
            case 6:
                return __('Jun');
            case 7:
                return __('Jul');
            case 8:
                return __('Aug');
            case 9:
                return __('Sep');
            case 10:
                return __('Oct');
            case 11:
                return __('Nov');
            case 12:
                return __('Dec');
            
            default:
                return null;
        }
    }
}







