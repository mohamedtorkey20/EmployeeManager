<?php

class EmployeeManager {
    private $file_name;
    private $dom;

    public function __construct($file_name) {
        $this->file_name = $file_name;

        if (!file_exists($this->file_name)) {
            $this->createNewXML();
        } else {
            $this->loadXML();
        }
    }

    private function createNewXML() {
        $this->dom = new DOMDocument('1.0', 'UTF-8');
        $root = $this->dom->createElement('employees');
        $this->dom->appendChild($root);
        $this->dom->save($this->file_name);
    }

    private function loadXML() {
        $this->dom = new DOMDocument();
        $this->dom->load($this->file_name);
    }

    public function insertEmployee($name, $email, $phone, $address) {
        $employee = $this->dom->createElement('employee');

        $nameElement = $this->dom->createElement('name', $name);
        $employee->appendChild($nameElement);

        $emailElement = $this->dom->createElement('email', $email);
        $employee->appendChild($emailElement);

        $phoneElement = $this->dom->createElement('phone', $phone);
        $employee->appendChild($phoneElement);

        $addressElement = $this->dom->createElement('address', $address);
        $employee->appendChild($addressElement);

        $root = $this->dom->documentElement;
        $root->appendChild($employee);

        $this->dom->save($this->file_name);
    }

    public function getEmployees() {
        $employees = [];
        $employeeNodes = $this->dom->getElementsByTagName('employee');
        foreach ($employeeNodes as $employeeNode) {
            $employee = [
                'name' => $employeeNode->getElementsByTagName('name')->item(0)->nodeValue,
                'email' => $employeeNode->getElementsByTagName('email')->item(0)->nodeValue,
                'phone' => $employeeNode->getElementsByTagName('phone')->item(0)->nodeValue,
                'address' => $employeeNode->getElementsByTagName('address')->item(0)->nodeValue
            ];
            $employees[] = $employee;
        }
        return $employees;
    }

    public function updateEmployee($employees) {
        $this->dom = new DOMDocument('1.0', 'UTF-8');
        $root = $this->dom->createElement('employees');
        foreach ($employees as $employee) {
            $employeeNode = $this->dom->createElement('employee');
            $nameElement = $this->dom->createElement('name', $employee['name']);
            $emailElement = $this->dom->createElement('email', $employee['email']);
            $phoneElement = $this->dom->createElement('phone', $employee['phone']);
            $addressElement = $this->dom->createElement('address', $employee['address']);

            $employeeNode->appendChild($nameElement);
            $employeeNode->appendChild($emailElement);
            $employeeNode->appendChild($phoneElement);
            $employeeNode->appendChild($addressElement);

            $root->appendChild($employeeNode);
        }
        $this->dom->appendChild($root);
        $this->dom->save($this->file_name);
    }

    public function deleteEmployee($index) {
        $employees = $this->getEmployees();
        unset($employees[$index]);
        $employees = array_values($employees);
        $this->updateEmployee($employees);
    }

    public function searchByName($name) {
        $employees = $this->getEmployees();
        $index = -1;
    
        foreach ($employees as $key=>$employee) {
            if (strpos(strtolower($employee['name']), strtolower($name)) !== false) {
                $index = $key;
            }
        }
    
        return $index;
    }
    

 

}
?>





