<? 
    function settingsToDataDropdown($fields_list){
        foreach ($fields_list as $field => $settings) {
            $fields[$field] = $settings['header'];
        }
        return $fields;
    }
    
    function arrayResultToDropdown($array, $key, $value){
        foreach ($array as $item) {
            $fields[$item[$key]] = $item[$value];
        }
        return $fields;
    }
    
    
    function form_required(){
        return " <span class='required_label'>(*)</span>";
    }
    
    
?>