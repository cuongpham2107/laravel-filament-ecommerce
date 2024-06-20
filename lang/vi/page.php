<?php

return [
    'general_settings' => [
        'title' => 'Cài đặt chung',
        'heading' => 'Cài đặt chung',
        'subheading' => 'Quản lý cài đặt chung của trang tại đây.',
        'navigationLabel' => 'Tổng quan',
        'sections' => [
            'site' => [
                'title' => 'Địa điểm',
                'description' => 'Quản lý cài đặt cơ bản.',
            ],
            'theme' => [
                'title' => 'chủ đề',
                'description' => 'Thay đổi chủ đề mặc định.',
            ],
        ],
        'fields' => [
            'brand_name' => 'Tên thương hiệu',
            'site_active' => 'Trạng thái trang web',
            'brand_logoHeight' => 'Chiều cao logo thương hiệu',
            'brand_logo' => 'Biểu tượng thương hiệu',
            'site_favicon' => 'Biểu tượng trang web',
            'primary' => 'Sơ đẳng',
            'secondary' => 'Sơ trung',
            'gray' => 'Xám',
            'success' => 'Thành công',
            'danger' => 'Sự nguy hiểm',
            'info' => 'Thông tin',
            'warning' => 'Cảnh báo',
        ],
    ],
    'mail_settings' => [
        'title' => 'Cài đặt thư',
        'heading' => 'Cài đặt thư',
        'subheading' => 'Quản lý cấu hình thư.',
        'navigationLabel' => 'Thư',
        'sections' => [
            'config' => [
                'title' => 'Cấu hình',
                'description' => 'Sự miêu tả',
            ],
            'sender' => [
                'title' => 'Từ (Người gửi)',
                'description' => 'Sự miêu tả',
            ],
            'mail_to' => [
                'title' => 'Gửi thư tới',
                'description' => 'Sự miêu tả',
            ],
        ],
        'fields' => [
            'placeholder' => [
                'receiver_email' => 'Người nhận email..',
            ],
            'driver' => 'Tài xế',
            'host' => 'Chủ nhà',
            'port' => 'Hải cảng',
            'encryption' => 'Mã hóa',
            'timeout' => 'Hết giờ',
            'username' => 'tên tài khoản',
            'password' => 'Mật khẩu',
            'email' => 'E-mail',
            'name' => 'Tên',
            'mail_to' => 'Gửi thư tới',
        ],
        'actions' => [
            'send_test_mail' => 'Gửi thư kiểm tra',
        ],
    ]
    ];
