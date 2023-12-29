<?php
session_start();
include('../../../../api/dbcon.php');
include('../../header.php');
if (isset($_GET['key'])) {
    $keyrequest = $_GET['key'];

    $ref_tbl = 'request';
    $reference = $database->getReference($ref_tbl);
    $query = $reference->getChild($keyrequest);
    $result = $query->getValue();

    if ($result > 0) {
        function getDaySuffix($day) {
            if ($day >= 11 && $day <= 13) {
                return 'th';
            }

            switch ($day % 10) {
                case 1:
                    return 'st';
                case 2:
                    return 'nd';
                case 3:
                    return 'rd';
                default:
                    return 'th';
            }
        }
?>

<div class="position-relative h-100 p-5">
    <img src="../../../../pictures/taliptiplogo.png" class="watermark z-n1" alt="taliptip_seal" width="500">
    <div class="position-relative h-100">
        <img src="../../../../pictures/taliptiplogo.png" class="position-absolute" alt="taliptip_seal" width="150">
        <div class="position-absolute bottom-0 end-0">
            <h4>Hon. MICHAEL M. RAMOS</h4>
            Barangay Captain
        </div>

        <header style="height: 150px">
            <div>
                <p class="header-center">
                    <span>REPUBLIC OF THE PHILIPPINES</span>
                    <span>PROVINCE OF BULACAN</span>
                    <span>MUNICIPALITY OF BULAKAN</span>
                    <span class="h4 fs-5">BARANGAY GOVERNMENT OF TALIPTIP</span>
                    <span class="h4 fs-5">OFFICE OF THE BARANGAY CAPTAIN</span>
                </p>
            </div>
        </header>

        <hr class="border border-black">

        <div class="p-3">
            <div class="text-center">
                <div class="h1"><i>BARANGAY CLEARANCE</i></div>
                <p class="text-start">
                    Pursuant to the provisions of Article No. 4, Section 152 of the Local Government Code of 1991 (R.A. 7160), the Barangay Government of Taliptip has decided to grant permission to <b><?=$result['displayName']?></b> of <b><?=$result['address']?></b> for livelihood as a <b><?=$result['occupation']?></b> in the waters covered by Barangay Taliptip, Bulakan, Bulacan.
                </p>
                <p class="text-start">
                    Please be advised to exercise caution near the boundaries restricted by the SMAI, San Miguel Aerocity Inc.
                </p>
                <p class="text-start">
                    The permission is granted upon the request of <?=($result['gender'] == 'Male' ? 'Mr.' : ($result['gender'] == 'Female' ? 'Ms.' : 'their'))?> <b><?=$result['lastName']?></b>, valid until December 31, <?=$result['validYearDate']?>.
                </p>
                <p class="text-start">
                    Granted this 
                    <?= $result['day'] . getDaySuffix($result['day'])?>
                    day of <?= $result['month'] . ' ' . $result['year']?> at the Office of the Barangay Captain, Taliptip, Bulakan, Bulacan.
                </p>
            </div>
        </div>
    </div>
</div>
<?php
    }
}
?>
<?php
include('../../footer.php');
?>
