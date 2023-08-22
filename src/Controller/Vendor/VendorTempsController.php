<?php

declare(strict_types=1);

namespace App\Controller\Vendor;

use Cake\Datasource\ConnectionManager;

use Cake\Mailer\Email;
use Cake\Mailer\Mailer;
use Cake\Mailer\TransportFactory;
use Cake\Routing\Router;
use Cake\Http\Client;


class VendorTempsController extends VendorAppController
{

    public function initialize(): void
    {
        parent::initialize();
        $flash = [];
        $this->set('flash', $flash);
    }

    
    public function view($id = null)
    {
        $flash = [];
        $this->set('headTitle', 'Profile');
        $session = $this->getRequest()->getSession();
        if ($id == null) {
            $id = $session->read('vendor_id');
        }

        $this->loadModel('VendorTemps');
        $vendorTemp = $this->VendorTemps->get($session->read('vendor_id'), [
            'contain' => ['VendorStatus','PurchasingOrganizations', 'AccountGroups', 'SchemaGroups'],
        ]);

        if ($this->request->is(['patch', 'post', 'put'])) {
            try {
                $request = $this->request->getData();
                $userData = [
                    'address' => $request['address1'],
                    'address_2' => $request['address2'],
                    'contact_person' => $request['contact_person'],
                    'contact_mobile' => $request['contact_mobiles'],
                    'contact_email' => $request['contact_email'],
                    'contact_department' => $request['contact_department'],
                    'contact_designation' => $request['contact_designation']
                ];


                $userObj = $this->VendorTemps->newEmptyEntity();
                $userObj = $this->VendorTemps->patchEntity($vendorTemp, $userData);

                if ($this->VendorTemps->save($userObj)) {
                    $response['status'] = 'success';
                    $response['message'] = 'Record saved successfully';
                    $flash = ['type' => 'success', 'msg' => 'Profle has been updated successfully'];
                    $this->set('flash', $flash);
                } else {
                    // Handle save error
                    $flash = ['type' => 'error', 'msg' => 'Failed to save user data'];
                    $this->set('flash', $flash);
                }
            } catch (\PDOException $e) {
                $flash = ['type' => 'error', 'msg' => ($e->getMessage())];
            } catch (\Exception $e) {
                $response['status'] = 'fail';
                $response['message'] = $e->getMessage();
                $flash = ['type' => 'error', 'msg' => ($e->getMessage())];
            }
            $this->set('flash', $flash);
        }

        $vendorTempView = $this->VendorTemps->find('all')->where(['update_flag' => $id]);
        $this->set('vendorTempView', $vendorTempView->toArray());
        $this->set('updatecount', $vendorTempView->count());
        $this->set(compact('vendorTemp'));
    }




    public function edit($id = null)
    {
        $this->loadModel("VendorTemps");
        $this->loadModel("VendorRegisteredOffices");
        $this->loadModel("CompanyCodes");
        $this->loadModel("ReconciliationAccounts");
        $this->loadModel("VendorBranchOffices");
        $this->loadModel("VendorSmallScales");
        $this->loadModel("VendorFacilities");
        $this->loadModel("VendorTurnovers");
        $this->loadModel("VendorIncometaxes");
        $this->loadModel('Currencies');
        $this->loadModel("VendorFactories");
        $this->loadModel("VendorPartnerAddress");
        $this->loadModel("VendorOtherdetails");
        $this->loadModel("VendorCommencements");
        $this->loadModel("VendorQuestionnaires");
        $this->loadModel("VendorReputedCustomers");
        $this->loadModel("Countries");
        $this->loadModel("States");
        $this->loadModel("Users");
        $session = $this->getRequest()->getSession();
        $vendorTemp = $this->VendorTemps->get($id, ['contain' => ['VendorStatus','CompanyCodes','ReconciliationAccounts','AccountGroups', 'PaymentTerms','SchemaGroups', 'PurchasingOrganizations']]);

        //echo '<pre>'; print_r($vendorTemp); exit;

        if ($this->request->is(['patch', 'post', 'put'])) {
            $request = $this->request->getData();
            try {
                //echo '<pre>';  print_r($request); exit;

                // Registered Office [working]
                $regoffc = $this->VendorRegisteredOffices->newEmptyEntity();
                $data = $request["registered_office"];
                $data["vendor_temp_id"] = $id;
                $regoffc = $this->VendorRegisteredOffices->patchEntity($regoffc, $data);
                if ($this->VendorRegisteredOffices->save($regoffc)) { }
                
                // Branch Office [working]
                foreach ($request["branch"]["branch_office"] as $key => $value) {
                    $branch = $this->VendorBranchOffices->newEmptyEntity();
                    $value["vendor_temp_id"] = $id;

                    if(isset($value["registration_certificate"]) && $value["registration_certificate"]->getSize() > 0) {
                        $fileName = $value["registration_certificate"]->getClientFilename();
                        $imagePath = WWW_ROOT . "uploads/vendor/" . $fileName;
                        $value["registration_certificate"]->moveTo($imagePath);
                        $value["registration_certificate"]= "uploads/vendor/" . $fileName;
                    } else { $value["registration_certificate"]=""; }

                    $branch = $this->VendorBranchOffices->patchEntity($branch, $value);
                    if ($this->VendorBranchOffices->save($branch)) { }
                }

                // Small Scale [working]
                $smallscale = $this->VendorSmallScales->newEmptyEntity();
                $data = $request["small_scale"];
                $data["vendor_temp_id"] = $id;

                if( isset($data["certificate_file"]) && $data["certificate_file"]->getSize() > 0 ) {
                    $fileName = $data["certificate_file"]->getClientFilename();
                    if($fileName){
                        $imagePath = WWW_ROOT . "uploads/smallscale/" . $fileName;
                        $data["certificate_file"]->moveTo($imagePath);
                        $data["certificate_file"]= "uploads/smallscale/" . $fileName;
                    }
                } else { $data["certificate_file"]= ""; }

                $smallscale = $this->VendorSmallScales->patchEntity($smallscale, $data);
                if ($this->VendorSmallScales->save($smallscale)) { }
                
                // Other Details [working]
                $data = $request["production_facility"];

                $intax = $this->VendorFacilities->newEmptyEntity();
                $data["vendor_temp_id"] = $id;

                
                if(isset($data["quality_control_file"]) && $data["quality_control_file"]->getSize() > 0) {
                    $fileName = $data["quality_control_file"]->getClientFilename();
                    $imagePath = WWW_ROOT . "uploads/quality_control/" . $fileName;
                    $data["quality_control_file"]->moveTo($imagePath);
                    $data["quality_control_file"]= "uploads/quality_control/" . $fileName;
                } else { $data["quality_control_file"]= ""; }

                if($data["lab_facility_file"] && $data["lab_facility_file"]->getSize() > 0) {
                    $fileName = $data["lab_facility_file"]->getClientFilename();
                    $imagePath = WWW_ROOT . "uploads/lab_facility/" . $fileName;
                    $data["lab_facility_file"]->moveTo($imagePath);
                    $data["lab_facility_file"]= "uploads/lab_facility/" . $fileName;
                } else { $data["lab_facility_file"]= ""; }

                if($data["isi_registration_file"] && $data["isi_registration_file"]->getSize() > 0) {
                    $fileName = $data["isi_registration_file"]->getClientFilename();
                    $imagePath = WWW_ROOT . "uploads/isi_registration/" . $fileName;
                    $data["isi_registration_file"]->moveTo($imagePath);
                    $data["isi_registration_file"]= "uploads/isi_registration/" . $fileName;
                 } else { $data["isi_registration_file"]= ""; }

                if($data["test_facility_file"] && $data["test_facility_file"]->getSize() > 0) {
                    $fileName = $data["test_facility_file"]->getClientFilename();
                    $imagePath = WWW_ROOT . "uploads/test_facility/" . $fileName;
                    $data["test_facility_file"]->moveTo($imagePath);
                    $data["test_facility_file"]= "uploads/test_facility/" . $fileName;
                } else { $data["test_facility_file"]= ""; }

                if($data["sales_services_file"] && $data["sales_services_file"]->getSize() > 0) {
                    $fileName = $data["sales_services_file"]->getClientFilename();
                    $imagePath = WWW_ROOT . "uploads/sales_services/" . $fileName;
                    $data["sales_services_file"]->moveTo($imagePath);
                    $data["sales_services_file"]= "uploads/sales_services/" . $fileName;
                } else { $data["sales_services_file"]= ""; }

                $intax = $this->VendorFacilities->patchEntity($intax, $data);
                if ($this->VendorFacilities->save($intax)) { }


                // Turn Over [working]
                $data = $request["annual_turnover"];
                $turnovr = $this->VendorTurnovers->newEmptyEntity();
                $data["vendor_temp_id"] = $id;
                $turnovr = $this->VendorTurnovers->patchEntity($turnovr, $data);
                if ($this->VendorTurnovers->save($turnovr)) { }

                // Reputed Customers [working]
                $otherdtl = $this->VendorOtherdetails->newEmptyEntity();
                $data = $request["other"];
                $data["vendor_temp_id"] = $id;

                if($data["six_sigma_file"] && $data["six_sigma_file"]->getSize() > 0) {
                    $fileName = $data["six_sigma_file"]->getClientFilename();
                    $imagePath = WWW_ROOT . "uploads/six_sigma/" . $fileName;
                    $data["six_sigma_file"]->moveTo($imagePath);
                    $data["six_sigma_file"]= "uploads/six_sigma/" . $fileName;
                } else  { $data["six_sigma_file"]= ""; }

                if($data["halal_file"] && $data["halal_file"]->getSize() > 0) {
                    $fileName = $data["halal_file"]->getClientFilename();
                    $imagePath = WWW_ROOT . "uploads/halal/" . $fileName;
                    $data["halal_file"]->moveTo($imagePath);
                    $data["halal_file"]= "uploads/halal/" . $fileName;
                } else { $data["halal_file"]= ""; }

                if($data["iso_file"] && $data["iso_file"]->getSize() > 0 ) {
                    $fileName = $data["iso_file"]->getClientFilename();
                    $imagePath = WWW_ROOT . "uploads/iso/" . $fileName;
                    $data["iso_file"]->moveTo($imagePath);
                    $data["iso_file"]= "uploads/iso/" . $fileName;
                } else { $data["iso_file"]= ""; }

                if($data["declaration_file"] && $data["declaration_file"]->getSize() > 0) {
                    $fileName = $data["declaration_file"]->getClientFilename();
                    $imagePath = WWW_ROOT . "uploads/declaration/" . $fileName;
                    $data["declaration_file"]->moveTo($imagePath);
                    $data["declaration_file"]= "uploads/declaration/" . $fileName;
                } else { $data["declaration_file"]= ""; }

                $otherdtl = $this->VendorOtherdetails->patchEntity($otherdtl, $data);                
                if ($this->VendorOtherdetails->save($otherdtl)) { }
                
                // Income Tax [working]
                $intax = $this->VendorIncometaxes->newEmptyEntity();
                $data = $request["income_tax"];
                $data["vendor_temp_id"] = $id;

                if(isset($data["certificate_file"]) && $data["certificate_file"]->getSize() > 0 ) {
                    $fileName = $data["certificate_file"]->getClientFilename();
                    $imagePath = WWW_ROOT . "uploads/certificate/" . $fileName;
                    $data["certificate_file"]->moveTo($imagePath);
                    $data["certificate_file"]= "uploads/certificate/" . $fileName;
                } else  { $data["certificate_file"]= ""; }

                if(isset($data["balance_sheet_file"]) && $data["balance_sheet_file"]->getSize() > 0) {
                    $fileName = $data["balance_sheet_file"]->getClientFilename();
                    $imagePath = WWW_ROOT . "uploads/balance_sheet/" . $fileName;
                    $data["balance_sheet_file"]->moveTo($imagePath);
                    $data["balance_sheet_file"]= "uploads/balance_sheet/" . $fileName;
                } else{ $data["balance_sheet_file"]= ""; }
                
                $intax = $this->VendorIncometaxes->patchEntity($intax, $data);
                if ($this->VendorIncometaxes->save($intax)) { }

                // Factory Address [working]

                //echo '<pre>'; print_r($request["prdflt"]["factory_office"]); exit;

                foreach ($request["prdflt"]["factory_office"] as $key => $value) {
                    $factory = $this->VendorFactories->newEmptyEntity();
                    $value["vendor_temp_id"] = $id;
                    // $value["factory_code"] = substr(strtoupper($value['country']), 0, 2)."_".substr(strtoupper($value['state']), 0, 2)."_".substr(strtoupper($value['city']), 0, 2)."_Unit".($key+1);
                    $value["factory_code"] = $value['country']."_".$value['state']."_".$value['city']."_Unit".($key+1);
                    
                    if(isset($value["installed_capacity_file"]) && $value["installed_capacity_file"]->getSize() > 0) {
                            $fileName = $value["installed_capacity_file"]->getClientFilename();
                            $imagePath = WWW_ROOT . "uploads/installed_capacity/" . $fileName;
                            $value["installed_capacity_file"]->moveTo($imagePath);
                            $value["installed_capacity_file"]= "uploads/installed_capacity/" . $fileName;
                    } else  { $value["installed_capacity_file"]= ""; }

                    if(isset($value["machinery_available_file"]) && $value["machinery_available_file"]->getSize() > 0) {
                        $fileName = $value["machinery_available_file"]->getClientFilename();
                        $imagePath = WWW_ROOT . "uploads/machinery_available/" . $fileName;
                        $value["machinery_available_file"]->moveTo($imagePath);
                        $value["machinery_available_file"]= "uploads/machinery_available/" . $fileName;
                    } else { $value["machinery_available_file"]= ""; }

                    if(isset($value["power_available_file"]) && $value["power_available_file"]->getSize() > 0) {
                        $fileName = $value["power_available_file"]->getClientFilename();
                        $imagePath = WWW_ROOT . "uploads/power_available/" . $fileName;
                        $value["power_available_file"]->moveTo($imagePath);
                        $value["power_available_file"]= "uploads/power_available/" . $fileName;
                    } else { $value["power_available_file"]= ""; }

                    if(isset($value["raw_material_file"]) && $value["raw_material_file"]->getSize() > 0) {
                        $fileName = $value["raw_material_file"]->getClientFilename();
                        $imagePath = WWW_ROOT . "uploads/raw_material/" . $fileName;
                        $value["raw_material_file"]->moveTo($imagePath);
                        $value["raw_material_file"]= "uploads/raw_material/" . $fileName;
                    } else { $value["raw_material_file"]= ""; }

                    $factory = $this->VendorFactories->patchEntity($factory, $value);
                    if ($factory_id = $this->VendorFactories->save($factory)) {
                        foreach ($value["commencement"] as $key => $value) {
                            $commencement = $this->VendorCommencements->newEmptyEntity();
                            $value["vendor_factory_id"] = $factory_id->id;
                            $value["vendor_temp_id"] = $id;
                            $commencement = $this->VendorCommencements->patchEntity($commencement, $value);
                            if ($this->VendorCommencements->save($commencement)) {  }
                        }
                    }
                }

                // Partner Address [Working]
                foreach ($request["other_address"]["partner"] as $key => $value) {
                    $partneraddr = $this->VendorPartnerAddress->newEmptyEntity();
                    $value["vendor_temp_id"] = $id;
                    $partneraddr = $this->VendorPartnerAddress->patchEntity($partneraddr, $value);
                    if ($this->VendorPartnerAddress->save($partneraddr)) { }
                }

                // Questionnaire Address [Working]
                foreach ($request["questionnaire"] as $key => $value) {
                    $partneraddr = $this->VendorQuestionnaires->newEmptyEntity();
                    $value["vendor_temp_id"] = $id;
                    $partneraddr = $this->VendorQuestionnaires->patchEntity($partneraddr, $value);
                    if ($this->VendorQuestionnaires->save($partneraddr)) { }
                }

                // Reputed Customers [Working]
                foreach ($request["reputed"]["customer"] as $key => $value) {
                    $partneraddr = $this->VendorReputedCustomers->newEmptyEntity();
                    $value["vendor_temp_id"] = $id;
                    $partneraddr = $this->VendorReputedCustomers->patchEntity($partneraddr, $value);
                    if ($this->VendorReputedCustomers->save($partneraddr)) { }
                }

                // Basic details
                $data = $request["vendor"];

                if(isset($data["gst_file"]) && $data["gst_file"]->getSize() > 0) {
                    $fileName = $data["gst_file"]->getClientFilename();
                    $imagePath = WWW_ROOT . "uploads/gst/" . $fileName;
                    $data["gst_file"]->moveTo($imagePath);
                    $data["gst_file"]= "uploads/gst/" . $fileName;
                } else { $data["gst_file"]= ""; }

                if(isset($data["pan_file"]) && $data["pan_file"]->getSize() > 0) {
                    $fileName = $data["pan_file"]->getClientFilename();
                    $imagePath = WWW_ROOT . "uploads/pan/" . $fileName;
                    $data["pan_file"]->moveTo($imagePath);
                    $data["pan_file"]= "uploads/pan/" . $fileName;
                } else { $data["pan_file"]= ""; }

                if( isset($data["bank_file"]) && $data["bank_file"]->getSize() > 0) {
                    $fileName = $data["bank_file"]->getClientFilename();
                    $imagePath = WWW_ROOT . "uploads/bank/" . $fileName;
                    $data["bank_file"]->moveTo($imagePath);
                    $data["bank_file"]= "uploads/bank/" . $fileName;
                }else { $data["bank_file"]= "";}
                // $data["order_currency"]= "INR";

                $vendorTemp = $this->VendorTemps->patchEntity($vendorTemp, $data);
                // print_r($vendorTemp);
                if ($this->VendorTemps->save($vendorTemp)) {
                    $flash = ['type' => 'success', 'msg' => 'Successfully Saved'];
                }
            } catch (\PDOException $e) {
                $flash = ['type' => 'error', 'msg' => ($e->getMessage())];
            }
        }

        $vt_countries = $this->Countries->find('list', ['keyField' => 'id', 'valueField' => 'country_name'])->toArray();
        $vt_state = $this->States->find('list', ['keyField' => 'id', 'valueField' => 'name'])->all();
        $countries = $this->Countries->find('list', ['keyField' => 'country_code', 'valueField' => 'country_name'])->toArray();
        $states = $this->States->find('list', ['keyField' => 'region_code', 'valueField' => 'name'])->all();

        $currencies = $this->Currencies->find('list', ['keyField' => 'code', 'valueField' => 'name'])->toArray();

        // $hasIndia = array_key_exists('IN', $countries);
        
        // if ($hasIndia) {
        //     unset($countries['India']);
        //     $countries = ['India' => 'India'] + $countries;
        // }

        $this->set(compact('vendorTemp', 'vt_countries', 'vt_state', 'countries', 'states','currencies'));
    }

}
