<?php

/*
  * Tệp này là một phần của Ithauaz/pages.
  *
  * Bản quyền (c) 2020 Ithauaz.
  *
  * Để biết đầy đủ thông tin về bản quyền và giấy phép, vui lòng xem GIẤY PHÉP
  * tệp đã được phân phối với mã nguồn này.
  */

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Schema\Builder;

return [
    'up' => function (Builder $schema) {
        $schema->table('pages', function (Blueprint $table) {
            $table->mediumText('content')->comment(' ')->change();
        });
    },
    'down' => function (Builder $schema) {
        $schema->table('pages', function (Blueprint $table) {
            $table->text('content')->comment('')->change();
        });
    },
];
