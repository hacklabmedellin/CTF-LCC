<?php
//Include Common Files @1-5471E0F2
define("RelativePath", ".");
include(RelativePath . "/Common.php");
include(RelativePath . "/Template.php");
include(RelativePath . "/Sorter.php");
include(RelativePath . "/Navigator.php");

//End Include Common Files
$page="Entering Promo Code";
global $REMOTE_ADDR;
global $now;
$ip=$REMOTE_ADDR;
$timeout = $now["timeout"];
$db1 = new clsDBNetConnect;
$db2 = new clsDBNetConnect;
$db3 = new clsDBNetConnect;
$db4 = new clsDBNetConnect;
$db5 = new clsDBNetConnect;
$times = time();

$SQL1 = "DELETE FROM online WHERE datet < $times";
$SQL2 = "SELECT * FROM online WHERE ip='$ip'";
$SQL3 = "UPDATE online SET datet=$times + $timeout, page='$page', user='" . CCGetUserName() . "' WHERE ip='$ip'";
$SQL4 = "INSERT INTO online (ip, datet, user, page) VALUES ('$ip', $times+$timeout,'". CCGetUserName() . "', '$page')";
$SQL5 = "SELECT * FROM online";

$db1->query($SQL1);
$db2->query($SQL2);
if($db2->next_record()){
        $db3->query($SQL3);
} else {
        $db4->query($SQL4);
}

$db5->query($SQL5);
$promoonline = $db5->num_rows();
unset($db1);
unset($db2);
unset($db3);
unset($db4);
unset($db5);
unset($SQL);
unset($SQL);
unset($SQL);
unset($SQL);
unset($SQL);
//Include Page implementation @2-503267A8
include("./Headeru.php");
//End Include Page implementation

//Include Page implementation @3-353B2997
include("./Footer.php");
//End Include Page implementation

//Initialize Page @1-3A2411EC
// Variables
$FileName = "";
$Redirect = "";
$Tpl = "";
$TemplateFileName = "";
$BlockToParse = "";
$ComponentName = "";

// Events;
$CCSEvents = "";
$CCSEventResult = "";

$FileName = "Promo.php";
$Redirect = "";
$TemplateFileName = "templates/Promo.html";
$BlockToParse = "main";
$PathToRoot = "./";
//End Initialize Page

//Authenticate User @1-7FED0150
CCSecurityRedirect("1;2", "login.php", $FileName, CCGetQueryString("QueryString", ""));
//End Authenticate User

//Initialize Objects @1-486D31B0

// Controls
$Header = new clsHeader();
$Header->BindEvents();
$Header->TemplatePath = "./";
$Header->Initialize();
$Footer = new clsFooter();
$Footer->BindEvents();
$Footer->TemplatePath = "./";
$Footer->Initialize();


$CCSEventResult = CCGetEvent($CCSEvents, "AfterInitialize");
//End Initialize Objects

//Execute Components @1-AB1E45CE
$Header->Operations();
$Footer->Operations();
//End Execute Components

//Go to destination page @1-BEB91355
if($Redirect)
{
    $CCSEventResult = CCGetEvent($CCSEvents, "BeforeUnload");
    header("Location: " . $Redirect);
    exit;
}
//End Go to destination page

//Initialize HTML Template @1-A0111C9D
$CCSEventResult = CCGetEvent($CCSEvents, "OnInitializeView");
$Tpl = new clsTemplate();
include './Lang/lang_class.php';
$Tpl->LoadTemplate(TemplatePath . $TemplateFileName, "main");
$CCSEventResult = CCGetEvent($CCSEvents, "BeforeShow");
//End Initialize HTML Template

if ($_GET["code"] && !$_GET["Cancel"]){
	
	$error = "";
	$query = "Select * from promos where code='" . mysql_escape_string($_GET["code"]) . "'";
	$db = new clsDBNetConnect;
	$db->query($query);
	if ($db->next_record()){
		if (time() < $db->f("start"))
		    $error = "This Offer Has Not Started Yet";
		if (time() > $db->f("end"))
		    $error = "This Offer Has Expired";
		$db2 = new clsDBNetConnect;
		$query = "select * from used_promos where user_id = '" . CCGetUserID() . "' and promo_id = '" . $db->f("id") . "'";
		$db2->query($query);
		if ($db2->next_record())
		    $error = "You Have Already Used that Promo Offer";
	}
	else {
		$error = "This Is Not a Valid Offer";
	}
	if (!$error) {
		if ($db->f("group")){
			$groupcheck = new clsDBNetConnect;
			$query = "select * from groups_users where user_id = '" . CCGetUserID() . "' and group_id = '" . $db->f("group") . "'";
			$groupcheck->query($query);
			if (!$groupcheck->next_record()){
				$groupcheck->query("select * from groups where id = '" . $db->f("group") . "'");
				if ($groupcheck->next_record()){
					$group = $groupcheck->f("title");
					$query = "insert into groups_users (`user_id`, `group_id`) values ('" . CCGetUserID() . "', '" . $db->f("group") . "')";
					$groupcheck->query($query);
					$grouptext = "You have been added to the $group group";
				}
			}
		}
		if ($db->f("amount")){
			$query = "INSERT INTO charges (`user_id` , `date` , `charge` , `cause` ) VALUES ('" . CCGetUserID() . "', " . time() . " , '" . $db->f("amount") . "', 'Promo Offer Code: " . $db->f("code") . "')";
            $db->query($query);
            $amounttext = "$" . $db->f("amount") . " has been added to your account<br>";
        }
		$error = "Thank You!  Promo Code Entered Successfully!  <br>" . $amounttext . $grouptext;
		$query = "INSERT INTO used_promos (`user_id` , `promo_id` , `date` ) VALUES ('" . CCGetUserID() . "', '" . $db->f("id") . "' , '" . time() . "')";
		$db->query($query);
	}
	$Tpl->SetVar("error", $error);
} elseif ($_GET["Cancel"]){
	header("Location: myaccount.php");
	exit;
}

//Show Page @1-8D0414C5
$Header->Show("Header");
$Footer->Show("Footer");
$Tpl->PParse("main", false);
//End Show Page

//Unload Page @1-AB7622EF
$CCSEventResult = CCGetEvent($CCSEvents, "BeforeUnload");
unset($Tpl);
//End Unload Page


?>
