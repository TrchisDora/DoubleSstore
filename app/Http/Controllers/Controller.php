<?php

namespace App\Http\Controllers;

abstract class Controller
{
    public function XuLyTen($name)
    {
        if (!is_string($name) || empty($name)) {
            throw new \InvalidArgumentException('Invalid name provided for slug generation.');
        }

        // Chuyển chuỗi thành chữ thường và loại bỏ khoảng trắng thừa
        $slug = strtolower(trim($name));

        // Xử lý các ký tự tiếng Việt có dấu (bao gồm cả chữ hoa)
        $slug = preg_replace('/[ÀÁẢÃẠÂẦẤẨẪẬàáảãạâầấẩẫậ]/u', 'a', $slug);
        $slug = preg_replace('/[ÈÉẺẼẸÊỀẾỂỄỆèéẻẽẹêềếểễệ]/u', 'e', $slug);
        $slug = preg_replace('/[ÌÍỈĨỊìíỉĩị]/u', 'i', $slug);
        $slug = preg_replace('/[ÒÓỎÕỌÔỒỐỔỖỘƠỜỚỞỠỢòóỏõọôồốổỗộơờớởỡợ]/u', 'o', $slug);
        $slug = preg_replace('/[ÙÚỦŨỤƯỪỨỬỮỰùúủũụưừứửữự]/u', 'u', $slug);
        $slug = preg_replace('/[ỲÝỶỸỴỳýỷỹỵ]/u', 'y', $slug);
        $slug = preg_replace('/[Đđ]/u', 'd', $slug); // Xử lý ký tự "Đ"
        
        // Xử lý các ký tự không phải là a-z, 0-9, khoảng trắng và dấu gạch ngang
        $slug = preg_replace('/[^a-z0-9\s-]/', '', $slug);
        
        // Thay thế khoảng trắng và dấu gạch ngang liên tiếp bằng một dấu gạch ngang duy nhất
        $slug = preg_replace('/[\s-]+/', '-', $slug);
        
        // Xóa dấu gạch ngang ở đầu và cuối chuỗi
        $slug = trim($slug, '-');

        return $slug;
    }

    public function XuLyAnh($Hinh, $TenSP) {
        $file_extension = pathinfo($Hinh, PATHINFO_EXTENSION);
        $XuLy = $this->XuLyTen($TenSP); // Gọi hàm XuLyTen đúng cách
        $new_filename = strtolower(str_replace(' ', '-', $XuLy)) . '.' . $file_extension;
        return $new_filename;
    }
}
