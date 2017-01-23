<?php
/**
 * Created by PhpStorm.
 * User: cod_llo
 * Date: 11.03.16
 * Time: 17:11
 */


/*
Модель получения мастер-индекса пациента
*/

/*
select top 10
ID, aaId, allAddresses, allDMSInsurances,
allIdentityDocuments, allOMSInsurances,
birthCertificateSerNum, bloodGroup, children,
deceaseDate, dmsInsurance, dob, dwellingType,
ein, enp, familyName, fullName, gender, givenName,
identifiers, identityDocumentSerNum, inn,
isForeigner, isHomeless, isMpiIdFirstAssignment,
isServicemanFamily, isTrustee, isUnidentified,
middleName,
 mpiId,
mpiIdUpdatedOn, mrn, newBornData,
occupation, omsPoliceSerNum, prevAddresses, prevIdentityDocuments,
prevNames, prevOMSInsurance, prevOccupations, privilege, rhesusFactor,
snils, socialStatus, trusteeList, actualAddress_addressLine,
actualAddress_apartment, actualAddress_block, actualAddress_building,
actualAddress_city, actualAddress_cityKladr, actualAddress_country,
actualAddress_district, actualAddress_districtKladr,
actualAddress_effectiveDate, actualAddress_house,
actualAddress_locality, actualAddress_okato, actualAddress_postalCode,
actualAddress_region, actualAddress_regionKladr, actualAddress_street,
actualAddress_streetKladr, baseClinic_code, baseClinic_codingSystem,
 baseClinic_extCode, baseClinic_extCodingSystem,
baseClinic_extName, baseClinic_name, birthAddress_addressLine,
 birthAddress_apartment, birthAddress_block, birthAddress_building,
 birthAddress_city, birthAddress_cityKladr, birthAddress_country,
birthAddress_district, birthAddress_districtKladr,
 birthAddress_effectiveDate, birthAddress_house,
birthAddress_locality, birthAddress_okato, birthAddress_postalCode,
 birthAddress_region, birthAddress_regionKladr, birthAddress_street,
 birthAddress_streetKladr, birthCertificate_docDate, birthCertificate_docNum,
birthCertificate_docSer, birthCertificate_docSource, birthCertificate_docType_code,
 birthCertificate_docType_codingSystem, birthCertificate_docType_extCode,
 birthCertificate_docType_extCodingSystem, birthCertificate_docType_extName,
 birthCertificate_docType_name, birthCertificate_expirationDate, citizenship_code,
citizenship_codingSystem, citizenship_extCode, citizenship_extCodingSystem,
citizenship_extName, citizenship_name, contactInfo_cellPhone,
 contactInfo_contactInfoString, contactInfo_email, contactInfo_fax,
contactInfo_homePhone, contactInfo_workPhone, deceaseAddress_addressLine,
 deceaseAddress_apartment, deceaseAddress_block, deceaseAddress_building,
 deceaseAddress_city, deceaseAddress_cityKladr, deceaseAddress_country,
 deceaseAddress_district, deceaseAddress_districtKladr, deceaseAddress_effectiveDate,
deceaseAddress_house, deceaseAddress_locality, deceaseAddress_okato,
 deceaseAddress_postalCode, deceaseAddress_region, deceaseAddress_regionKladr,
deceaseAddress_street, deceaseAddress_streetKladr, identityDocument_docDate,
identityDocument_docNum, identityDocument_docSer, identityDocument_docSource,
identityDocument_docType_code, identityDocument_docType_codingSystem, identityDocument_docType_extCode,
identityDocument_docType_extCodingSystem, identityDocument_docType_extName, identityDocument_docType_name,
identityDocument_expirationDate, legalAddress_addressLine, legalAddress_apartment, legalAddress_block,
 legalAddress_building, legalAddress_city, legalAddress_cityKladr, legalAddress_country,
 legalAddress_district, legalAddress_districtKladr, legalAddress_effectiveDate, legalAddress_house,
legalAddress_locality, legalAddress_okato, legalAddress_postalCode, legalAddress_region,
legalAddress_regionKladr, legalAddress_street, legalAddress_streetKladr, levelOfEducation_code,
 levelOfEducation_codingSystem, levelOfEducation_extCode, levelOfEducation_extCodingSystem,
 levelOfEducation_extName, levelOfEducation_name, maritalStatus_code, maritalStatus_codingSystem,
maritalStatus_extCode, maritalStatus_extCodingSystem, maritalStatus_extName, maritalStatus_name,
 omsInsurance_effectiveDate, omsInsurance_expirationDate, omsInsurance_insuranceCompany_code,
omsInsurance_insuranceCompany_codingSystem, omsInsurance_insuranceCompany_extCode,
 omsInsurance_insuranceCompany_extCodingSystem, omsInsurance_insuranceCompany_extName,
 omsInsurance_insuranceCompany_name, omsInsurance_insuranceCompanyKladr_code,
omsInsurance_insuranceCompanyKladr_codingSystem, omsInsurance_insuranceCompanyKladr_extCode,
 omsInsurance_insuranceCompanyKladr_extCodingSystem, omsInsurance_insuranceCompanyKladr_extName,
omsInsurance_insuranceCompanyKladr_name, omsInsurance_insuranceCompanyOkato, omsInsurance_policyNum,
 omsInsurance_policySer, omsInsurance_policyType_code, omsInsurance_policyType_codingSystem,
 omsInsurance_policyType_extCode, omsInsurance_policyType_extCodingSystem, omsInsurance_policyType_extName,
 omsInsurance_policyType_name, postalAddress_addressLine, postalAddress_apartment, postalAddress_block,
postalAddress_building, postalAddress_city, postalAddress_cityKladr, postalAddress_country, postalAddress_district,
 postalAddress_districtKladr, postalAddress_effectiveDate, postalAddress_house, postalAddress_locality, postalAddress_okato,
postalAddress_postalCode, postalAddress_region, postalAddress_regionKladr, postalAddress_street,
 postalAddress_streetKladr, race_code, race_codingSystem, race_extCode, race_extCodingSystem,
 race_extName, race_name
from isc_mprl.Patient
*/
class Mpi_model extends CI_Model
{
    public $cacheDB_MPI;


    /*Имя базы*/
    public $GlobalDB = "";




    public function __construct()
    {
        $this->cacheDB_MPI = $this->load->database('mpi', TRUE);
        date_default_timezone_set('Europe/London');


    }

    /*Выдает MPI по familyName, givenName, middleName, dob, */
    /*$this->mpi_model->get('КАЗАНЦЕВ','ВЯЧЕСЛАВ','ПЕТРОВИЧ','1973-03-21');*/
    public function get($familyName,$givenName,$middleName,$dob)
    {
        $dob = strtotime( $dob );
        $dob = date( 'Y-m-d', $dob );


       /* $familyName=mb_convert_encoding($familyName,"Windows-1251","UTF-8");
        $givenName=mb_convert_encoding($givenName,"Windows-1251","UTF-8");
        $middleName=mb_convert_encoding($middleName,"Windows-1251","UTF-8");*/

        $sql="select mpiid, dob
            from isc_mprl.Patient
            where
            familyName='$familyName'
            and givenName='$givenName'
            and dob = '$dob'
            and middleName='$middleName'
            ";


        $query=$this->cacheDB_MPI->query($sql);
        return $query->row(0);
    }

    public function PatientFrom_POLD_FIO($familyName,$givenName,$middleName,$dob)
    {
        $dob = strtotime( $dob );
        $dob = date( 'Y-m-d', $dob );
        $sql="select *
from isc_mprl_dbo.POLD_FIO
where
SURNAME='$familyName'
AND
SECNAME='$middleName'
AND
NAME='$givenName'
AND BIRTHDAY='$dob'
order by D_MODIF desc
";
        $query=$this->cacheDB_MPI->query($sql);
        return $query->row(0);
    }

    /*Вставляет/обновляет данные об докторе*/
    /*вставка и обновление идет паралельно*/
    /*особенноость Cache*/
    /*$doctor - массив */
    public function incert_update($lpu)
    {
        $this->icache->update($this->LPUCache,$lpu);  // Object instances will always be lower case
    }








}