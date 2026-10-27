<?php
// require_once "../controllers/operation.controller.php";
// require_once "../models/operation.model.php";
require_once "../controllers/checkwriter.controller.php";
require_once "../models/checkwriter.model.php";
require_once "../views/modules/session.php";
$editAccntModal= new editLiaisonModal();
$editAccntModal->showEditLiaisonModal();    

class editLiaisonModal {
    public function showEditLiaisonModal() {

        $l_id = $_GET['l_id'];
      
        $data = (new ControllerCheckWriter)->ctrGetLiaisonInfo($l_id);

        foreach ($data as &$item) {
            $edit_full_name = $item["full_name"];
            $edit_address = $item["address"];
            $edit_contact_no = $item["contact_no"];
            $edit_sex = $item["sex"];
            $edit_type_of_id = $item["type_of_id"];
            $edit_id_no = $item["id_no"];
            $edit_birth_date = $item["birth_date"];
            $edit_birth_place = $item["birth_place"];
            $edit_nationality = $item["nationality"];
            $edit_citizenship = $item["citizenship"];
        }
        
        $item['card'] ='
         
        <input type="hidden" class="form-control" id="l_id" name="l_id" readonly value="'.$l_id.'" required placeholder="Enter Folder Name">
            <div class="row">
                <div class="col-sm-12 form-group">
                    <label for="full_name" class="col-form-label">FULL NAME</label>
                    <input type="text" required style="border: 1px solid #08655d;" value="'.$edit_full_name.'" class="form-control text-success" id="full_name" placeholder="Enter liaison fullname" name="full_name">
                </div>
            </div>
                <div class="row">
                <div class="col-sm-12 form-group">
                    <label for="address" class="col-form-label">ADDRESS</label>
                    <input type="text" required style="border: 1px solid #08655d;" value="'.$edit_address.'" class="form-control text-success" id="address" placeholder="Enter address" name="address">
                </div>
            </div>
            <div class="row">
                <div class="col-sm-6 form-group">
                    <label for="contact_no" class="col-form-label">CONRACT NO.</label>
                    <input type="text" required style="border: 1px solid #08655d;" value="'.$edit_contact_no.'" class="form-control text-success" id="contact_no" placeholder="Enter contact number" name="contact_no">
                </div>
                    <div class="col-sm-4 form-group">
                    <label for="sex" class="col-form-label">SEX</label>
                    <select name="sex" id="sex" style="border: 1px solid #08655d;" value="'.$edit_sex.'" class="form-control text-success">
                        <option value="Male">Male</option>
                        <option value="Female">Female</option>
                        <option value="Others">Others</option>
                    </select>
                </div>
            </div>
                <div class="row">
                <div class="col-sm-6 form-group">
                    <label for="type_of_id" class="col-form-label">TYPE OF ID</label>
                    <select name="type_of_id" id="type_of_id" style="border: 1px solid #08655d;" value="'.$edit_type_of_id.'" class="form-control text-success">
                        <option value="SSS">SSS</option>
                        <option value="GSIS">GSIS</option>
                        <option value="others">Others</option>
                    </select>
                </div>
                    <div class="col-sm-6 form-group">
                    <label for="id_no" class="col-form-label">ID NO</label>
                    <input type="text" required style="border: 1px solid #08655d;" value="'.$edit_id_no.'" class="form-control text-success"  id="id_no" placeholder="Enter ID number..." name="id_no">
                </div>
            </div>
            <div class="row">
                <div class="col-sm-6 form-group">
                    <label for="birth_date" class="col-form-label">BIRTH DATE</label>
                    <input type="date" required style="border: 1px solid #08655d;" value="'.$edit_birth_date.'" class="form-control text-success"  id="birth_date" placeholder="Enter birth date..." name="birth_date">
                </div>
                    <div class="col-sm-6 form-group">
                    <label for="birth_place" class="col-form-label">BIRTH PLACE</label>
                    <input type="text" required style="border: 1px solid #08655d;" value="'.$edit_birth_place.'" class="form-control text-success"  id="birth_place" placeholder="Enter birth place" name="birth_place">
                </div>
            </div>
            <div class="row">
                <div class="col-sm-6 form-group">
                    <label for="nationality" class="col-form-label">NATIONALITY</label>
                    <input type="text" required style="border: 1px solid #08655d;" value="'.$edit_nationality.'" class="form-control text-success"  id="nationality" placeholder="Enter nationality" name="nationality">
                </div>
                    <div class="col-sm-6 form-group">
                    <label for="citizenship" class="col-form-label">CITIZENSHIP</label>
                    <input type="text" required style="border: 1px solid #08655d;" value="'.$edit_citizenship.'" class="form-control text-success"  id="citizenship" placeholder="Enter citezenship" name="citizenship">
                </div>
            </div>

    ';

        echo json_encode($data);

    }
}
