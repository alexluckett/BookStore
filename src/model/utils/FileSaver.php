<?php

/**
 * Saves files to a given directory, restricting based on file types.
 *
 * @author Alex Luckett <lucketta@aston.ac.uk>
 */
class FileSaver {
    
    private $uploadPath;
    private $permittedFileTypes;
    
    public function __construct($uploadPath, array $permittedFileTypes) {
        $this->uploadPath = $uploadPath;
        $this->permittedFileTypes = [];
        
        foreach($permittedFileTypes as $fileType) { // converting all to lower case, so need to loop rather than use array directly
            $lowerCaseType = strtolower($fileType);
            
            array_push($this->permittedFileTypes, $lowerCaseType);
        }
    }
    
    /**
     * Saves a file from a form upload into the correct directory.
     * 
     * @param array $uploadedFile
     * @throws Exception
     */
    public function saveFile(array $uploadedFile) {
        $target = $this->uploadPath."/".$uploadedFile["name"];
        
        if($this->isValidFileType($target) && !file_exists($target)) {
            $success = move_uploaded_file($uploadedFile["tmp_name"], "$target");

            if(!$success) {
                throw new Exception("File unsuccessfully uploaded.");
            }
        } else {
            throw new Exception("Invalid file upload. File already exists or is not a permitted file type.");
        }
    }
    
    /**
     * Ensures a file (path) is the correct file extension.
     * 
     * @param string $path
     * @return boolean
     */
    private function isValidFileType($path) {
        $fileType = pathinfo($path, PATHINFO_EXTENSION);
        
        return in_array($fileType, $this->permittedFileTypes);
    }
    
}
