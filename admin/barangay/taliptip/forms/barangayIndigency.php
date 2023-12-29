<?php
session_start();
include('../../../../api/dbcon.php');
include ('../../header.php');

if (isset($_GET['key'])) {
    $keyrequest = $_GET['key'];

    $ref_tbl = 'request';
    $reference = $database->getReference($ref_tbl);
    $query = $reference->getChild($keyrequest);
    $result = $query->getValue();

    if ($result > 0) {
            ?>
    <div class="position-relative h-100 p-5">
        <img src="../../../../pictures/taliptiplogo.png" class="watermark z-n1" alt="taliptip_seal" width="500">
        <div class="position-relative h-100">
            <img src="../../../../pictures/taliptiplogo.png" class="position-absolute" alt="taliptip_seal" width="150">
            <div class="position-absolute bottom-0 end-0">
                <h4>Igg. MICHAEL M. RAMOS</h4>
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
                    <div class="h1"><i>BARANGAY INDIGENCY</i></div>
                    <p class="text-start">
                        <b>To whoever this may be:</b>
                    </p>
                    <p class="text-start">
                        This is to certify that <b class="text-uppercase"><?=$result['displayName']?></b>, <b><?=$result['age']?></b> years old, <b><?=$result['gender']?></b>, <b><?=$result['civilstatus']?></b>, residing at <b><?=$result['address']?></b>, Bulakan, Bulacan, possesses good moral character and is a member of several underprivileged families in this barangay.
                    </p>
                    <p class="text-start">
                        After our interview, it was discovered that the <b>client (bearer)</b> is in need of <?=$result['purpose']?> for <?=($result['gender'] == 'Male' ? 'his' : ($result['gender'] == 'Female' ? 'her' : 'their'))?> -- <?=$result['otherPurpose']?>
                    </p>
                    <p class="text-start">
                        This certification is issued upon the request of <b class="text-uppercase"><?=$result['displayName']?></b>.
                    </p>
                    <p class="text-start">
                        For <?=$result['purpose']?>
                    </p>
                    <p class="text-start">
                        Given this <b><?=$result['day']?></b>th day of <b><?=$result['month']?></b>, year <b><?=$result['year']?></b>.
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
include ('../../footer.php');
?>