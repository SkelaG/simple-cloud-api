<?php

namespace App\Enums;

enum FileInfoType: string
{
    case Folder = 'folder';
    case File = 'file';

    /**
     * @return string[]
     */
    public static function toValuesArray(): array
    {
        $values = [];
        foreach (self::cases() as $case) {
            $values[] = $case->value;
        }

        return $values;
    }
}
