<?php

/**
 * Description of FileUploader
 *
 * @author Alex Luckett <lucketta@aston.ac.uk>
 */
class FileUploader {
    
    private $uploadPath;
    private $permittedFileTypes;
    
    public function __construct($uploadPath, array $permittedFileTypes) {
        $this->uploadPath = $uploadPath;
        $this->permittedFileTypes = [];
        
        foreach($permittedFileTypes as $fileType) {
            $lowerCaseType = strtolower($fileType);
            
            array_push($this->permittedFileTypes, $lowerCaseType);
        }
    }
    
    public function saveFile(array $uploadedFile) {
        $target = $this->uploadPath."/".$uploadedFile["name"];
        
        if($this->isValidFileType($target) && !file_exists($target)) {
            $success = move_uploaded_file($uploadedFile["tmp_name"], "$target"); // fixme

            if(!$success) {
                throw new Exception("File unsuccessfully uploaded.");
            }
        } else {
            throw new Exception("Invalid file upload. File already exists or is not a permitted file type.");
        }
    }
    
    private function isValidFileType($path) {
        $fileType = pathinfo($path, PATHINFO_EXTENSION);
        
        return in_array($fileType, $this->permittedFileTypes);
    }
    
}
