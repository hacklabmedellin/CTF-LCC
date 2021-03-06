<?php
session_start();
define("RelativePath", ".");
include(RelativePath . "/Classes.php");
include(RelativePath . "/db_mysql.php");
include(RelativePath . "/Config/vars.php");
include(RelativePath . "/Version.php");
?>
<?
$name="itechclassifieds";
$www = "www.scriptpermit.com"; // your main site (remote server)
$domain = $_SERVER['SERVER_NAME'];
$ipaddress=gethostbyname($domain);
$type = "full";
$verss = "3.0";
$ref = $_SERVER["REQUEST_URI"];
$needle = '/';
$result = substr($ref, 0, -strlen($ref)+strrpos($ref, $needle));
$url = "http://$www/dcheck/conf.php?url=$domain&name=$name&ipaddress=$ipaddress&path=$result&type=$type&verss=$verss";
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_REFERER, $url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_USERAGENT, $_SERVER['HTTP_USER_AGENT']);
$resres = curl_exec($ch);
curl_close($ch);
$grep = $resres;
$is = explode("|", $grep);
if($is[0]=="no")
{
echo "$is[1]";
exit();
}
$name="";
$url="";
?>
<?
define("TemplatePath", "./");  //Do not Change!!!

define("ServerURL", $Home_URL);

define("SecureURL", $Secure_URL);



$ShortWeekdays = array("Sun", "Mon", "Tue", "Wed", "Thu", "Fri", "Sat");

$Weekdays = array("Sunday", "Monday", "Tuesday", "Wednesday", "Thursday", "Friday", "Saturday");

$ShortMonths =  array("Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec");

$Months = array("January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December");



define("ccsInteger", 1);

define("ccsFloat", 2);

define("ccsText", 3);

define("ccsDate", 4);

define("ccsBoolean", 5);

define("ccsMemo", 6);



define("ccsPost", 1);

define("ccsGet", 2);



define("ccsYear", 1);

define("ccsMonth", 2);

define("ccsDay", 3);

define("ccsHour", 4);

define("ccsMinute", 5);

define("ccsSecond", 6);

define("ccsAmPm", 7);

define("ccsShortMonth", 8);

define("ccsFullMonth", 9);

define("ccsWeek", 10);

define("ccsGMT", 11);

//End Initialize Common Variables



//NetConnect Connection Class @-9F68533F

class clsDBNetConnect extends DB_MySQL

{



    var $DateFormat;

    var $BooleanFormat;

    var $LastSQL;

    var $Errors;



    var $RecordsCount;

    var $RecordNumber;

    var $PageSize;

    var $AbsolutePage;



    var $SQL = "";

    var $Where = "";

    var $Order = "";



    var $Parameters;

    var $wp;



    function clsDBNetConnect()

    {

        $this->Initialize();

    }



    function Initialize()

    {

        global $dbs;

        $this->AbsolutePage = 0;

        $this->PageSize = 0;

        $this->Database = $dbs["DB_NAME"];

        $this->Host = $dbs["DB_HOST"];

        $this->User = $dbs["DB_USER"];

        $this->Password = $dbs["DB_PASS"];

        $this->Persistent = true;

        $this->RecordsCount = 0;

        $this->RecordNumber = 0;

        $this->DateFormat = Array("mm", "/", "dd", "/", "yyyy", " ", "HH", ":", "nn", ":", "ss");

        $this->BooleanFormat = Array(1, 0, "");

        $this->Errors = New clsErrors();

    }



    function MoveToPage($Page)

    {

        if($this->RecordNumber == 0 && $this->PageSize != 0 && $Page != 0)

            while($this->RecordNumber < ($Page - 1) * $this->PageSize && $this->next_record())

                $this->RecordNumber++;

    }

    function PageCount()

    {

        return ceil($this->RecordsCount / $this->PageSize);

    }



    function ToSQL($Value, $ValueType)

    {

        if(strlen($Value) || ($ValueType == ccsBoolean && is_bool($Value)))

        {

            if($ValueType == ccsInteger || $ValueType == ccsFloat)

            {

                return doubleval(str_replace(",", ".", $Value));

            }

            else if($ValueType == ccsDate)

            {

                return "'" . addslashes($Value) . "'";

            }

            else if($ValueType == ccsBoolean)

            {

                if(is_bool($Value))

                    $Value = $Value ? "1" : "0";

                else if(is_numeric($Value))

                    $Value = intval($Value);

                else if(strtoupper($Value) == "TRUE" || strtoupper($Value) == "FALSE")

                    $Value = strtoupper($Value);

                else

                    $Value = "'" . addslashes($Value) . "'";

                return $Value;

            }

            else

            {

                return "'" . addslashes($Value) . "'";

            }

        }

        else

        {

            return "NULL";

        }

    }



    function SQLValue($Value, $ValueType)

    {

        if(!strlen($Value))

        {

            return "NULL";

        }

        else

        {

            if($ValueType == ccsInteger || $ValueType == ccsFloat)

            {

                return doubleval(str_replace(",", ".", $Value));

            }

            else if($ValueType == ccsBoolean)

            {

                if(is_bool($Value))

                    $Value = $Value ? "1" : "0";

                else if(is_numeric($Value))

                    $Value = intval($Value);

                else if(strtoupper($Value) == "TRUE" || strtoupper($Value) == "FALSE")

                    $Value = strtoupper($Value);

                else

                    $Value = addslashes($Value);

                return $Value;

            }

            else

            {

                return addslashes($Value);

            }

        }

    }}

//End NetConnect Connection Class



//CCToHTML @0-93F44B0D

function CCToHTML($Value)

{

  return htmlspecialchars($Value);

}

//End CCToHTML



//CCToURL @0-88FAFE26

function CCToURL($Value)

{

  return urlencode($Value);

}

//End CCToURL



//CCGetEvent @0-25FB255C

function CCGetEvent($events, $event_name)

{

  $function_name = (is_array($events) && isset($events[$event_name])) ? $events[$event_name] : "";

  if($function_name && function_exists($function_name))

    $result = call_user_func ($function_name);

  else

    $result = $function_name;

  return $result;

}

//End CCGetEvent



//CCGetValueHTML @0-0180C79D

function CCGetValueHTML($db, $fieldname)

{

  return htmlspecialchars($db->f($fieldname));

}

//End CCGetValueHTML



//CCGetValue @0-EAF96C23

function CCGetValue($db, $fieldname)

{

  return $db->f($fieldname);

}

//End CCGetValue



//CCGetSession @0-E3E0F8B8

function CCGetSession($param_name)

{

  global $_POST;

  global $_GET;

  global ${$param_name};

  

      if ($_COOKIE["NCuserid"] && !stristr($param_name,"Recent")){

          if ($param_name=="UserID")

            $query = "select user_id from users where user_id=" . $_COOKIE["NCuserid"];

          if ($param_name=="UserLogin")

            $query = "select user_login from users where user_id=" . $_COOKIE["NCuserid"];

          if ($param_name=="UserPassword")

            $query = "select password from users where user_id=" . $_COOKIE["NCuserid"];

          if ($param_name=="GroupID")

            $query = "select status from users where user_id=" . $_COOKIE["NCuserid"];

            $db = new clsDBNetConnect();

            $db->query($query);

            $Result = $db->next_record();

            if ($param_name=="UserID")

                $param_value = $db->f("user_id");

            if ($param_name=="UserLogin")

                $param_value = $db->f("user_login");

            if ($param_name=="UserPassword")

                $param_value = $db->f("password");

            if ($param_name=="GroupID")

                $param_value = $db->f("status");

    }





	else {



	  $param_value = "";

	  if(!isset($_POST[$param_name]) && !isset($_GET[$param_name]) && $_SESSION[$param_name])

		$param_value = $_SESSION[$param_name];

	}



  return $param_value;

}

//End CCGetSession



//CCSetSession @0-1F870DB4

function CCSetSession($param_name, $param_value)

{

  global ${$param_name};

  if(session_is_registered($param_name))

    session_unregister($param_name);

  ${$param_name} = $param_value;

  session_register($param_name);

  $_SESSION[$param_name] = $param_value;

}

//End CCSetSession



//CCGetCookie @0-A733FBF9

function CCGetCookie($param_name)

{

  global $_COOKIE;

  return isset($_COOKIE[$param_name]) ? $_COOKIE[$param_name] : "";

}

//End CCGetCookie



//CCSetCookie @0-985DB889

function CCSetCookie($param_name, $param_value)

{

  setcookie ($param_name, $param_value, time() + 3600 * 24 * 366);

}

//End CCSetCookie



//CCStrip @0-F5DAB56A

function CCStrip($value)

{

  if(get_magic_quotes_gpc() == 0)

    return $value;

  else

    return stripslashes($value);

}

//End CCStrip



//CCGetParam @0-C3E4B53D

function CCGetParam($parameter_name, $default_value)

{

  global $_POST;

  global $_GET;



  $parameter_value = "";

  if(isset($_POST[$parameter_name]))

    $parameter_value = CCStrip($_POST[$parameter_name]);

  else if(isset($_GET[$parameter_name]))

    $parameter_value = CCStrip($_GET[$parameter_name]);

  else

    $parameter_value = $default_value;



  return $parameter_value;

}

//End CCGetParam



//CCGetFromPost @0-DFCA8196

function CCGetFromPost($parameter_name, $default_value)

{

  global $_POST;



  $parameter_value = "";

  if(isset($_POST[$parameter_name]))

    $parameter_value = CCStrip($_POST[$parameter_name]);

  else

    $parameter_value = $default_value;



  return $parameter_value;

}

//End CCGetFromPost



//CCGetFromGet @0-A1936D83

function CCGetFromGet($parameter_name, $default_value)

{

  global $_GET;



  $parameter_value = "";

  if(isset($_GET[$parameter_name]))

    $parameter_value = CCStrip($_GET[$parameter_name]);

  else

    $parameter_value = $default_value;



  return $parameter_value;

}

//End CCGetFromGet



//CCToSQL @0-422F5B92

function CCToSQL($Value, $ValueType)

{

  if(!strlen($Value))

  {

    return "NULL";

  }

  else

  {

    if($ValueType == ccsInteger || $ValueType == ccsFloat)

    {

      return doubleval(str_replace(",", ".", $Value));

    }

    else

    {

      return "'" . str_replace("'", "''", $Value) . "'";

    }

  }

}

//End CCToSQL



//CCDLookUp @0-A937C7E0

function CCDLookUp($field_name, $table_name, $where_condition, $db)

{

  $sql = "SELECT " . $field_name . " FROM " . $table_name . ($where_condition ? " WHERE " . $where_condition : "");

  return CCGetDBValue($sql, $db);

}

//End CCDLookUp



//CCGetDBValue @0-417763E3

function CCGetDBValue($sql, $db)

{

  $db->query($sql);

  if($db->next_record())

    return $db->f(0);

  else

    return "";

}

//End CCGetDBValue



//CCGetListValues @0-5D6EE70E

function CCGetListValues($db, $sql, $where = "", $order_by = "", $bound_column = "", $text_column = "")

{

    $values = "";

    if(!strlen($bound_column))

        $bound_column = 0;

    if(!strlen($text_column))

        $text_column = 1;

    if(strlen($where))

        $sql .= " WHERE " . $where;

    if(strlen($order_by))

        $sql .= " ORDER BY " . $order_by;

    $db->query($sql);

    if ($db->next_record())

    {

        do

        {

            $values[] = array($db->f($bound_column), $db->f($text_column));

        } while ($db->next_record());

    }

    return $values;

}



//End CCGetListValues



//CCBuildSQL @0-AD00EEB4

function CCBuildSQL($sql, $where = "", $order_by = "")

{

    if(strlen($where))

        $sql .= " WHERE " . $where;

    if(strlen($order_by))

        $sql .= " ORDER BY " . $order_by;

    return $sql;

}



//End CCBuildSQL



//CCGetRequestParam @0-1C3CB87C

function CCGetRequestParam($ParameterName, $Method)

{

  global $_POST;

  global $_GET;

  $ParameterValue = "";



  if($Method == ccsGet && isset($_GET[$ParameterName]))

    $ParameterValue = CCStrip($_GET[$ParameterName]);

  else if($Method == ccsPost && isset($_POST[$ParameterName]))

    $ParameterValue = CCStrip($_POST[$ParameterName]);



  return $ParameterValue;

}

//End CCGetRequestParam



//CCGetQueryString @0-F67D7840

function CCGetQueryString($CollectionName, $RemoveParameters)

{

  global $_POST;

  global $_GET;

  $querystring = "";

  $postdata = "";



  if($CollectionName == "Form")

    $querystring = CCCollectionToString($_POST, $RemoveParameters);

  else if($CollectionName == "QueryString")

    $querystring = CCCollectionToString($_GET, $RemoveParameters);

  else if($CollectionName == "All")

  {

    $querystring = CCCollectionToString($_GET, $RemoveParameters);

    $postdata = CCCollectionToString($_POST, $RemoveParameters);

    if(strlen($postdata) > 0 && strlen($querystring) > 0)

      $querystring .= "&" . $postdata;

    else

      $querystring .= $postdata;

  }

  else

    die("1050: Common Functions. CCGetQueryString Function. " .

      "The CollectionName contains an illegal value.");



  return $querystring;

}



//End CCGetQueryString



//CCCollectionToString @0-883F2B49

function CCCollectionToString($ParametersCollection, $RemoveParameters)

{

  $Result = "";

  if(is_array($ParametersCollection))

  {

    reset($ParametersCollection);

    foreach($ParametersCollection as $ItemName => $ItemValues)

    {

      $Remove = false;

      if(is_array($RemoveParameters))

      {

        for($I = 0; $I < sizeof($RemoveParameters); $I++)

        {

          if($RemoveParameters[$I] == $ItemName)

          {

            $Remove = true;

            break;

          }

        }

      }

      if(!$Remove)

      {

        if(is_array($ItemValues))

          for($J = 0; $J < sizeof($ItemValues); $J++)

            $Result .= "&" . $ItemName . "[]=" . urlencode(CCStrip($ItemValues[$J]));

        else

           $Result .= "&" . $ItemName . "=" . urlencode(CCStrip($ItemValues));

      }

    }

  }



  if(strlen($Result) > 0)

    $Result = substr($Result, 1);

  return $Result;

}

//End CCCollectionToString



//CCAddParam @0-56573314

function CCAddParam($querystring, $ParameterName, $ParameterValue)

{

  global $_GET;

  $Result = "";

  $CurrentParameterValue = isset($_GET[$ParameterName]) ? $_GET[$ParameterName] : "";

  $Result = str_replace($ParameterName . "=" . urlencode($CurrentParameterValue), "", $querystring);

  $Result .= "&" . $ParameterName . "=" . urlencode($ParameterValue);

  $Result = str_replace("&&", "&", $Result);

  if (substr($Result, 0, 1) == "&")

    $Result = substr($Result, 1);

  return $Result;

}



//End CCAddParam



//CCRemoveParam @0-9355EFB5

function CCRemoveParam($querystring, $ParameterName)

{

  global $_GET;

  $Result = "";

  $Result = str_replace($ParameterName . "=" . urlencode($_GET[$ParameterName]), "", $querystring);

  $Result = str_replace("&&", "&", $Result);

  if (substr($Result, 0, 1) == "&")

    $Result = substr($Result, 1);

  return $Result;

}

//End CCRemoveParam



//CCRemoveParam @0-27B4AC18

function CCGetOrder($DefaultSorting, $SorterName, $SorterDirection, $MapArray)

{

  if(is_array($MapArray) && isset($MapArray[$SorterName]))

    if(strtoupper($SorterDirection) == "DESC")

      $OrderValue = ($MapArray[$SorterName][1] != "") ? $MapArray[$SorterName][1] : $MapArray[$SorterName][0] . " DESC";

    else

      $OrderValue = $MapArray[$SorterName][0];

  else

    $OrderValue = $DefaultSorting;



  return $OrderValue;

}

//End CCRemoveParam



//CCFormatDate @0-44F7371B

function CCFormatDate($DateToFormat, $FormatMask)

{

  global $ShortWeekdays;

  global $Weekdays;

  global $ShortMonths;

  global $Months;



  if($DateToFormat < 0) $DateToFormat = "";

  if(is_array($FormatMask) && strlen($DateToFormat))

  {

    $masks = array(

      "GeneralDate" => "n/j/y, h:i:s A", "LongDate" => "l, F j, Y",

      "ShortDate" => "h/j/y", "LongTime" => "g:i:s A",

      "ShortTime" => "H:i", "d" => "j", "dd" => "d",

      "m" => "n", "mm" => "m", "yy" => "y", "yyyy" => "Y",

      "h" => "g", "hh" => "h", "H" => "G", "HH" => "H",

      "nn" => "i", "ss" => "s", "AM/PM" => "A", "am/pm" => "a"

    );

    $FormatedDate = "";

    for($i = 0; $i < sizeof($FormatMask); $i++)

    {

      if(isset($masks[$FormatMask[$i]]))

      {

        $FormatedDate .= date($masks[$FormatMask[$i]], $DateToFormat);

      }

      else

      {

        switch ($FormatMask[$i])

        {

          case "ddd":

            $FormatedDate .= $ShortWeekdays[date("w", $DateToFormat)];

            break;

          case "dddd":

            $FormatedDate .= $Weekdays[date("w", $DateToFormat)];

            break;

          case "w":

            $FormatedDate .= (date("w", $DateToFormat) + 1);

            break;

          case "ww":

            $FormatedDate .= ceil((6 + date("z", $DateToFormat) - date("w", $DateToFormat)) / 7);

            break;

          case "mmm":

            $FormatedDate .= $ShortMonths[date("n", $DateToFormat) - 1];

            break;

          case "mmmm":

            $FormatedDate .= $Months[date("n", $DateToFormat) - 1];

            break;

          case "q":

            $FormatedDate .= ceil(date("n", $DateToFormat) / 3);

            break;

          case "y":

            $FormatedDate .= (date("z", $DateToFormat) + 1);

            break;

          case "n":

            $FormatedDate .= intval(date("i", $DateToFormat));

            break;

          case "s":

            $FormatedDate .= intval(date("s", $DateToFormat));

            break;

          case "A/P":

            $am = date("A", $DateToFormat);

            $FormatedDate .= $am[0];

            break;

          case "a/p":

            $am = date("a", $DateToFormat);

            $FormatedDate .= $am[0];

            break;

          case "GMT":

            $gmt = date("Z", $DateToFormat) / (60 * 60);

            if($gmt >= 0) $gmt = "+" . $gmt;

            $FormatedDate .= $gmt;

            break;

          default:

            $FormatedDate .= $FormatMask[$i];

            break;

        }

      }

    }

  }

  else

  {

    $FormatedDate = $DateToFormat;

  }

  return $FormatedDate;

}

//End CCFormatDate



//CCValidateDate @0-77D4F419

function CCValidateDate($ValidatingDate, $FormatMask)

{

  $IsValid = true;

  if(is_array($FormatMask) && strlen($ValidatingDate))

  {

    $RegExp = CCGetDateRegExp($FormatMask);

    $IsValid = preg_match($RegExp[0], $ValidatingDate, $matches);

  }

  else if(strlen($ValidatingDate))

  {

    $IsValid = is_numeric($ValidatingDate);

  }



  return $IsValid;

}

//End CCValidateDate



//CCParseDate @0-ECFCFB7D

function CCParseDate($ParsingDate, $FormatMask)

{

  global $ShortMonths;

  global $Months;



  if(is_array($FormatMask) && strlen($ParsingDate))

  {

    $DateArray = array(0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0);

    $RegExp = CCGetDateRegExp($FormatMask);

    $IsValid = preg_match($RegExp[0], $ParsingDate, $matches);

    for($i = 1; $i < sizeof($matches); $i++)

      $DateArray[$RegExp[$i]] = $matches[$i];



    if($DateArray[ccsMonth] == 0 && ($DateArray[ccsFullMonth] != 0 || $DateArray[ccsShortMonth] != 0))

    {

      if($DateArray[ccsFullMonth] != 0)

        $DateArray[ccsMonth] = CCGetIndex($Months, $DateArray[ccsFullMonth], true) + 1;

      else if($DateArray[ccsShortMonth] != 0)

        $DateArray[ccsMonth] = CCGetIndex($ShortMonths, $DateArray[ccsShortMonth], true) + 1;

    }



    if($DateArray[ccsHour] < 12 && strtoupper($DateArray[ccsAmPm][0]) == "P")

      $DateArray[ccsHour] += 12;



    if($DateArray[ccsHour] == 12 && strtoupper($DateArray[ccsAmPm][0]) == "A")

      $DateArray[ccsHour] = 0;



    if(($DateArray[ccsYear] < 1970 || $DateArray[ccsYear] > 2069) && strlen($DateArray[ccsYear]) > 2)

      $DateArray[ccsYear] = substr($DateArray[ccsYear], strlen($DateArray[ccsYear]) - 3);



    $ParsingDate = mktime ($DateArray[ccsHour], $DateArray[ccsMinute], $DateArray[ccsSecond], $DateArray[ccsMonth], $DateArray[ccsDay], $DateArray[ccsYear]);

    if($ParsingDate < 0) $ParsingDate = "";



  }



  return $ParsingDate;

}

//End CCParseDate



//CCGetDateRegExp @0-9237C33C

function CCGetDateRegExp($FormatMask)

{

  global $ShortWeekdays;

  global $Weekdays;

  global $ShortMonths;

  global $Months;



  $RegExp = false;

  if(is_array($FormatMask))

  {

    $masks = array(

      "GeneralDate" => array("(\d{1,2})\/(\d{1,2})\/(\d{2}), (\d{2}):(\d{2}):(\d{2}) (AM|PM)", ccsMonth, ccsDay, ccsYear, ccsHour, ccsMinute, ccsSecond, ccsAmPm),

      "LongDate" => array("(" . join("|", $Weekdays) . "), (" . join("|", $Months) . ") (\d{1,2}), (\d{4})", ccsWeek, ccsFullMonth, ccsDay, ccsYear),

      "ShortDate" => array("(\d{1,2})\/(\d{1,2})\/(\d{2})", ccsMonth, ccsDay, ccsYear),

      "LongTime" => array("(\d{1,2}):(\d{2}):(\d{2}) (AM|PM)", ccsHour, ccsMinute, ccsSecond, ccsAmPm),

      "ShortTime" => array("(\d{2}):(\d{2})", ccsHour, ccsMinute),

      "d" => array("(\d{1,2})", ccsDay),

      "dd" => array("(\d{2})", ccsDay),

      "ddd" => array("(" . join("|", $ShortWeekdays) . ")", ccsWeek),

      "dddd" => array("(" . join("|", $Weekdays) . ")", ccsWeek),

      "w" => array("\d"), "ww" => array("\d{1,2}"),

      "m" => array("(\d{1,2})", ccsMonth), "mm" => array("(\d{2})", ccsMonth),

      "mmm" => array("(" . join("|", $ShortMonths) . ")", ccsShortMonth),

      "mmmm" => array("(" . join("|", $Months) . ")", ccsFullMonth),

      "y" => array("\d{1,3}"), "yy" => array("(\d{2})", ccsYear),

      "yyyy" => array("(\d{4})", ccsYear), "q" => array("\d"),

      "h" => array("(\d{1,2})", ccsHour), "hh" => array("(\d{2})", ccsHour),

      "H" => array("(\d{1,2})", ccsHour), "HH" => array("(\d{2})", ccsHour),

      "n" => array("(\d{1,2})", ccsMinute), "nn" => array("(\d{2})", ccsMinute),

      "s" => array("(\d{1,2})", ccsSecond), "ss" => array("(\d{2})", ccsSecond),

      "AM/PM" => array("(AM|PM)", ccsAmPm), "am/pm" => array("(am|pm)", ccsAmPm),

      "A/P" => array("(A|P)", ccsAmPm), "a/p" => array("(a|p)", ccsAmPm),

      "GMT" => array("([\+\-]\d{2})", ccsGMT)

    );

    $RegExp[0] = "";

    $RegExpIndex = 1;

    for($i = 0; $i < sizeof($FormatMask); $i++)

    {

      if(isset($masks[$FormatMask[$i]]))

      {

        $MaskArray = $masks[$FormatMask[$i]];

        $RegExp[0] .= $MaskArray[0];

        for($j = 1; $j < sizeof($MaskArray); $j++)

          $RegExp[$RegExpIndex++] = $MaskArray[$j];

      }

      else

        $RegExp[0] .= CCAddEscape($FormatMask[$i]);

    }

    $RegExp[0] = "/^" . $RegExp[0] . "$/";

  }



  return $RegExp;

}

//End CCGetDateRegExp



//CCAddEscape @0-06D50C27

function CCAddEscape($FormatMask)

{

  $meta_characters = array("\\", "^", "\$", ".", "[", "|", "(", ")", "?", "*", "+", "{", "-", "]", "/");

  for($i = 0; $i < sizeof($meta_characters); $i++)

    $FormatMask = str_replace($meta_characters[$i], "\\" . $meta_characters[$i], $FormatMask);

  return $FormatMask;

}

//End CCAddEscape



//CCGetIndex @0-8DB8E12C

function CCGetIndex($ArrayValues, $Value, $IgnoreCase = true)

{

  $index = false;

  for($i = 0; $i < sizeof($ArrayValues); $i++)

  {

    if(($IgnoreCase && strtoupper($ArrayValues[$i]) == strtoupper($Value)) || ($ArrayValues[$i] == $Value))

    {

      $index = $i;

      break;

    }

  }

  return $index;

}

//End CCGetIndex



//CCFormatNumber @0-B39A1596

function CCFormatNumber($NumberToFormat, $FormatArray)

{

  $Result = "";

  if(is_array($FormatArray) && strlen($NumberToFormat))

  {

    $IsExtendedFormat = $FormatArray[0];

    $IsNegative = ($NumberToFormat < 0);

    $NumberToFormat = abs($NumberToFormat);

    $NumberToFormat *= $FormatArray[7];



    if($IsExtendedFormat) // Extended format

    {

      $DecimalSeparator = $FormatArray[2];

      $PeriodSeparator = $FormatArray[3];

      $ObligatoryBeforeDecimal = 0;

      $DigitsBeforeDecimal = 0;

      $BeforeDecimal = $FormatArray[5];

      $AfterDecimal = $FormatArray[6];

      if(is_array($BeforeDecimal)) {

        for($i = 0; $i < sizeof($BeforeDecimal); $i++) {

          if($BeforeDecimal[$i] == "0") {

            $ObligatoryBeforeDecimal++;

            $DigitsBeforeDecimal++;

          } else if($BeforeDecimal[$i] == "#")

            $DigitsBeforeDecimal++;

        }

      }

      $ObligatoryAfterDecimal = 0;

      $DigitsAfterDecimal = 0;

      if(is_array($AfterDecimal)) {

        for($i = 0; $i < sizeof($AfterDecimal); $i++) {

          if($AfterDecimal[$i] == "0") {

            $ObligatoryAfterDecimal++;

            $DigitsAfterDecimal++;

          } else if($AfterDecimal[$i] == "#")

            $DigitsAfterDecimal++;

        }

      }



      $NumberToFormat = number_format($NumberToFormat, $DigitsAfterDecimal, ".", "");

      $NumberParts = explode(".", $NumberToFormat);



      $LeftPart = $NumberParts[0];

      if($LeftPart == "0") $LeftPart = "";

      $RightPart = isset($NumberParts[1]) ? $NumberParts[1] : "";

      $j = strlen($LeftPart);



      if(is_array($BeforeDecimal))

      {

        $RankNumber = 0;

        $i = sizeof($BeforeDecimal);

        while ($i > 0 || $j > 0)

        {

          if(($i > 0 && ($BeforeDecimal[$i - 1] == "#" || $BeforeDecimal[$i - 1] == "0")) || ($j > 0 && $i < 1)) {

            $RankNumber++;

            $CurrentSeparator = ($RankNumber % 3 == 1 && $RankNumber > 3 && $j > 0) ? $PeriodSeparator : "";

            if($ObligatoryBeforeDecimal > 0 && $j < 1)

              $Result = "0" . $CurrentSeparator . $Result;

            else if($j > 0)

              $Result = $LeftPart[$j - 1] . $CurrentSeparator . $Result;

            $j--;

            $ObligatoryBeforeDecimal--;

            $DigitsBeforeDecimal--;

            if($DigitsBeforeDecimal == 0 && $j > 0)

              for(;$j > 0; $j--)

              {

                $RankNumber++;

                $CurrentSeparator = ($RankNumber % 3 == 1 && $RankNumber > 3 && $j > 0) ? $PeriodSeparator : "";

                $Result = $LeftPart[$j - 1] . $CurrentSeparator . $Result;

              }

          }

          else if ($i > 0) {

            $BeforeDecimal[$i - 1] = str_replace("##", "#", $BeforeDecimal[$i - 1]);

            $BeforeDecimal[$i - 1] = str_replace("00", "0", $BeforeDecimal[$i - 1]);

            $Result = $BeforeDecimal[$i - 1] . $Result;

          }

          $i--;

        }

      }



      // Left part after decimal

      $RightResult = "";

      $IsRightNumber = false;

      if(is_array($AfterDecimal))

      {

        $IsZero = true;

        for($i = sizeof($AfterDecimal); $i > 0; $i--) {

          if($AfterDecimal[$i - 1] == "#" || $AfterDecimal[$i - 1] == "0") {

            if($DigitsAfterDecimal > $ObligatoryAfterDecimal) {

              if($RightPart[$DigitsAfterDecimal - 1] != "0")

                $IsZero = false;

              if(!$IsZero)

              {

                $RightResult = $RightPart[$DigitsAfterDecimal - 1] . $RightResult;

                $IsRightNumber = true;

              }

            } else {

              $RightResult = $RightPart[$DigitsAfterDecimal - 1] . $RightResult;

              $IsRightNumber = true;

            }

            $DigitsAfterDecimal--;

          } else {

            $AfterDecimal[$i - 1] = str_replace("##", "#", $AfterDecimal[$i - 1]);

            $AfterDecimal[$i - 1] = str_replace("00", "0", $AfterDecimal[$i - 1]);

            $RightResult = $AfterDecimal[$i - 1] . $RightResult;

          }

        }

      }



      if($IsRightNumber)

        $Result .= $DecimalSeparator ;



      $Result .= $RightResult;



      if(!$FormatArray[4] && $IsNegative && $Result)

        $Result = "-" . $Result;

    }

    else // Simple format

    {

      if(!$FormatArray[4] && $IsNegative)

        $Result = "-" . $FormatArray[5] . number_format($NumberToFormat, $FormatArray[1], $FormatArray[2], $FormatArray[3]) . $FormatArray[6];

      else

        $Result = $FormatArray[5] . number_format($NumberToFormat, $FormatArray[1], $FormatArray[2], $FormatArray[3]) . $FormatArray[6];

    }



    if(!$FormatArray[8])

      $Result = htmlspecialchars($Result);



    if(strlen($FormatArray[9]))

      $Result = "<FONT COLOR=\"" . $FormatArray[9] . "\">" . $Result . "</FONT>";

  }

  else

  {

    $Result = $NumberToFormat;

  }



  return $Result;

}

//End CCFormatNumber



//CCValidateNumber @0-FEE6A9BD

function CCValidateNumber($NumberValue, $FormatArray)

{

  $is_valid = true;

  if(strlen($NumberValue))

  {

    $NumberValue = CCClearNumber($NumberValue, $FormatArray);

    $is_valid = is_numeric($NumberValue);

  }

  return $is_valid;

}



//End CCValidateNumber



//CCParseNumber @0-E60D9B7D

function CCParseNumber($NumberValue, $FormatArray, $DataType)

{

  $NumberValue = CCClearNumber($NumberValue, $FormatArray);

  if(is_array($FormatArray) && strlen($NumberValue))

  {



    if($FormatArray[4]) // Is use parenthesis

      $NumberValue = - abs(doubleval($NumberValue));



    $NumberValue /= $FormatArray[7];

  }



  if(strlen($NumberValue))

  {

    if($DataType == ccsFloat)

      $NumberValue = doubleval($NumberValue);

    else

      $NumberValue = intval($NumberValue);

  }



  return $NumberValue;

}

//End CCParseNumber



//CCClearNumber @0-D9C3137B

function CCClearNumber($NumberValue, $FormatArray)

{

  if(is_array($FormatArray))

  {

    $IsExtendedFormat = $FormatArray[0];



    if($IsExtendedFormat) // Extended format

    {

      $BeforeDecimal = $FormatArray[5];

      $AfterDecimal = $FormatArray[6];



      if(is_array($BeforeDecimal))

      {

        for($i = sizeof($BeforeDecimal); $i > 0; $i--) {

          if($BeforeDecimal[$i - 1] != "#" && $BeforeDecimal[$i - 1] != "0")

          {

            $search = $BeforeDecimal[$i - 1];

            $search = ($search == "##" || $search == "00") ? $search[0] : $search;

            $NumberValue = str_replace($search, "", $NumberValue);

          }

        }

      }



      if(is_array($AfterDecimal))

      {

        for($i = sizeof($AfterDecimal); $i > 0; $i--) {

          if($AfterDecimal[$i - 1] != "#" && $AfterDecimal[$i - 1] != "0")

          {

            $search = $AfterDecimal[$i - 1];

            $search = ($search == "##" || $search == "00") ? $search[0] : $search;

            $NumberValue = str_replace($search, "", $NumberValue);

          }

        }

      }

    }

    else // Simple format

    {

      if(strlen($FormatArray[5]))

        $NumberValue = str_replace($FormatArray[5], "", $NumberValue);

      if(strlen($FormatArray[6]))

        $NumberValue = str_replace($FormatArray[6], "", $NumberValue);

    }



    if(strlen($FormatArray[3]))

      $NumberValue = str_replace($FormatArray[3], "", $NumberValue); // Period separator

    if(strlen($FormatArray[2]))

      $NumberValue = str_replace($FormatArray[2], ".", $NumberValue); // Decimal separator



    if(strlen($FormatArray[9]))

    {

      $NumberValue = str_replace("<FONT COLOR=\"" . $FormatArray[9] . "\">", "", $NumberValue);

      $NumberValue = str_replace("</FONT>", "", $NumberValue);

    }

  }

  $NumberValue = str_replace(",", ".", $NumberValue); // Decimal separator



  return $NumberValue;

}

//End CCClearNumber



//CCParseInteger @0-FDF2EE85

function CCParseInteger($NumberValue, $FormatArray)

{

  return CCParseNumber($NumberValue, $FormatArray, ccsInteger);

}

//End CCParseInteger



//CCParseFloat @0-C9EAEA95

function CCParseFloat($NumberValue, $FormatArray)

{

  return CCParseNumber($NumberValue, $FormatArray, ccsFloat);

}

//End CCParseFloat



//CCFormatBoolean @0-4E964142

function CCFormatBoolean($BooleanValue, $Format)

{

  $Result = $BooleanValue;



  if(is_array($Format))

  {

    if($BooleanValue)

      $Result = $Format[0];

    else if(strval($BooleanValue) == "0" || $BooleanValue === false)

      $Result = $Format[1];

    else

      $Result = $Format[2];

  }



  return $Result;

}

//End CCFormatBoolean



//CCParseBoolean @0-0C7716BC

function CCParseBoolean($Value, $Format)

{

  $Result = $Value;

  if(is_array($Format))

  {

    if(strtolower(strval($Value)) == strtolower(strval($Format[0])))

      $Result = true;

    else if(strtolower(strval($Value)) == strtolower(strval($Format[1])))

      $Result = false;

    else

      $Result = "";

  }

  return $Result;

}

//End CCParseBoolean



//CCCheckSSL @0-E299E90E

function CCCheckSSL()

{

  global $now;

  $protocol = getenv("HTTPS");

  if($protocol != "on")

  {

    header("Location: " . $now["secureurl"] . "MakePayment.php");

    //echo "SSL connection error. This page can be accessed only via secured connection.";

    exit;



  }

}



//End CCCheckSSL



//CCSecurityRedirect @0-AB361364

function CCSecurityRedirect($GroupsAccess, $URL, $ReturnPage, $QueryString)

{

    $ErrorType = CCSecurityAccessCheck($GroupsAccess);

    if($ErrorType != "success")

    {

        if(!strlen($URL))

            $Link = "login.php";

        else

            $Link = $URL;

        if(strlen($QueryString))

            $ReturnPage .= "?" . $QueryString;

        header("Location: " . $Link . "?ret_link=" . urlencode($ReturnPage) . "&type=" . $ErrorType);

        exit;

    }

}

//End CCSecurityRedirect



//CCSecurityAccessCheck @0-7B496647

function CCSecurityAccessCheck($GroupsAccess)

{

    $ErrorType = "success";

    if(!strlen(CCGetUserID()))

    {

        $ErrorType = "notLogged";

    }

    else

    {

        $GroupID = CCGetGroupID();

        if(!strlen($GroupID))

        {

            $ErrorType = "groupIDNotSet";

        }

        else

        {

            if(!CCUserInGroups($GroupID, $GroupsAccess))

                $ErrorType = "illegalGroup";

        }

    }

    return $ErrorType;

}

//End CCSecurityAccessCheck



//CCGetUserID @0-6FAFFFAE

function CCGetUserID()

{

    return CCGetSession("UserID");

}

//End CCGetUserID



//CCGetGroupID @0-89F10997

function CCGetGroupID()

{

    return CCGetSession("GroupID");

}

//End CCGetGroupID



//CCGetUserLogin @0-ACD25564

function CCGetUserLogin()

{

    return CCGetSession("UserLogin");

}

//End CCGetUserLogin



//CCGetUserPassword @0-FF9DADAF

function CCGetUserPassword()

{

    return CCGetSession("UserPassword");

}

//End CCGetUserPassword



//CCUserInGroups @0-51407098

function CCUserInGroups($GroupID, $GroupsAccess)

{

    $Result = "";

    if(strlen($GroupsAccess))

    {

        $GroupNumber = intval($GroupID);

        while(!$Result && $GroupNumber > 0)

        {

            $Result = (strpos(";" . $GroupsAccess . ";", ";" . $GroupNumber . ";") !== false);

            $GroupNumber--;

        }

    }

    else

    {

        $Result = true;

    }

    return $Result;

}

//End CCUserInGroups



//CCLoginUser @0-CDA5F2E4

function CCLoginUser($Login, $Password)

{

    $db = new clsDBNetConnect();

    $SQL = "SELECT user_id, status FROM users WHERE user_login=" . $db->ToSQL($Login, ccsText) . " AND user_password=" . $db->ToSQL($Password, ccsText);

    $db->query($SQL);

    $Result = $db->next_record();

    if($Result)

    {

        CCSetSession("UserID", $db->f("user_id"));

        CCSetSession("UserLogin", $Login);

        CCSetSession("UserPassword", $Password);

        CCSetSession("GroupID", $db->f("status"));

        

		if ($_REQUEST["stay_logged"]) {

			setcookie("NCuserid",$db->f("user_id"),time() + 60*60*24*365,"/","");

    		setcookie("NCpassword",$Password,time() + 60*60*24*365,"/","");

    	}

    }

    unset($db);

    return $Result;

}

//End CCLoginUser



//CCLogoutUser @0-AD68F376

function CCLogoutUser()

{

    CCSetSession("UserID", "");

    CCSetSession("UserLogin", "");

    CCSetSession("UserPassword", "");

    CCSetSession("GroupID", "");

    

    if ($_COOKIE){

    	setcookie("NCuserid","",time() - 60*60*24*365,"/","");

    	setcookie("NCpassword","",time() - 60*60*24*365,"/","");

    }

}

//End CCLogoutUser



function CCGetUserName()

{

    if(CCGetSession("UserLogin")){

                return CCGetSession("UserLogin");

        } else {

                return "Guest";

        }

}

//SecurePass

function SecurePass()

{

    GLOBAL $config_NumberOfWords, $config_MaxNumberOfDigitBetweenWords, $config_DigitsAfterLastWord;

    mt_srand ((float) microtime() * 1000000);

    $securePassword = "";



    $safeEnglishWords = secure_password_get_words();

    $count = count($safeEnglishWords);

    FOR ($i=0; $i < $config_NumberOfWords; $i++) {

        $securePassword .= $safeEnglishWords[mt_rand(0,$count)];

        If ($config_DigitsAfterLastWord OR $i + 1 != $config_NumberOfWords) $securePassword .= mt_rand(0,pow(10,$config_MaxNumberOfDigitBetweenWords) -1);

    }

        return $securePassword;

}



function secure_password_get_words () {

    $array = Array( 'a', 'able', 'about', 'above', 'accept', 'accident', 'accuse', 'across', 'act',

'activist', 'actor', 'add', 'administration', 'admit', 'advise', 'affect', 'afraid', 'after', 'again',

 'against', 'age', 'agency', 'aggression', 'ago', 'agree', 'agriculture', 'aid', 'aim', 'air',

'airplane', 'airport', 'alive', 'all', 'ally', 'almost', 'alone', 'along', 'already', 'also',

'although', 'always', 'ambassador', 'amend', 'ammunition', 'among', 'amount', 'an', 'anarchy',

'ancient', 'and', 'anger', 'animal', 'anniversary', 'announce', 'another', 'answer', 'any',

'apologize', 'appeal', 'appear', 'appoint', 'approve', 'area', 'argue', 'arms', 'army', 'around',

'arrest', 'arrive', 'art', 'artillery', 'as', 'ash', 'ask', 'assist', 'astronaut', 'asylum', 'at',

'atmosphere', 'atom', 'attack', 'attempt', 'attend', 'automobile', 'autumn', 'awake', 'award', 'away',

'back', 'bad', 'balance', 'ball', 'balloon', 'ballot', 'ban', 'bank', 'bar', 'base', 'battle', 'be',

 'beach', 'beat', 'beauty', 'because', 'become', 'bed', 'beg', 'begin', 'behind', 'believe', 'bell',

 'belong', 'below', 'best', 'betray', 'better', 'between', 'big', 'bill', 'bird', 'bite', 'bitter',

 'black', 'blame', 'blanket', 'bleed', 'blind', 'block', 'blood', 'blow', 'blue', 'boat', 'body',

 'boil', 'bomb', 'bone', 'book', 'border', 'born', 'borrow', 'both', 'bottle', 'bottom', 'box',

 'boy', 'brain', 'brave', 'bread', 'break', 'breathe', 'bridge', 'brief', 'bright', 'bring',

 'broadcast', 'brother', 'brown', 'build', 'bullet', 'burn', 'burst', 'bury', 'bus', 'business',

 'busy', 'but', 'buy', 'by', 'cabinet', 'call', 'calm', 'camera', 'campaign', 'can', 'cancel',

 'cancer', 'candidate', 'cannon', 'capital', 'capture', 'car', 'care', 'careful', 'carry', 'case',

 'cat', 'catch', 'cattle', 'cause', 'ceasefire', 'celebrate', 'cell', 'center', 'century',

 'ceremony', 'chairman', 'champion', 'chance', 'change', 'charge', 'chase', 'cheat', 'check',

 'cheer', 'chemicals', 'chieg', 'child', 'choose', 'church', 'circle', 'citizen', 'city',

 'civil', 'civilian', 'clash', 'clean', 'clear', 'clergy', 'climb', 'clock', 'close', 'cloth',

 'clothes', 'cloud', 'coal', 'coalition', 'coast', 'coffee', 'cold', 'collect', 'colony', 'color',

 'come', 'comedy', 'command', 'comment', 'committee', 'common', 'communicate', 'company', 'compete',

 'complete', 'compromise', 'computer', 'concern', 'condemn', 'condition', 'conference', 'confirm',

 'conflict', 'congratulate', 'congress', 'connect', 'conservative', 'consider', 'contain',

 'continent', 'continue', 'control', 'convention', 'cook', 'cool', 'cooperate', 'copy', 'correct',

 'cost', 'costitution', 'cotton', 'count', 'country', 'court', 'cover', 'cow',

 'coward', 'crash', 'create', 'creature', 'credit', 'crew', 'crime', 'criminal', 'crisis',

 'criticize', 'crops', 'cross', 'crowd', 'cruel', 'crush', 'cry', 'culture', 'cure', 'current',

 'custom', 'cut', 'dam', 'damage', 'dance', 'danger', 'dark', 'date', 'daughter', 'day', 'dead',

 'deaf', 'deal', 'debate', 'decide', 'declare', 'deep', 'defeat', 'defend', 'deficit', 'degree',

 'delay', 'delegate', 'demand', 'democracy', 'demonstrate', 'denounce', 'deny', 'depend', 'deplore',

 'deploy', 'describe', 'desert', 'design', 'desire', 'destroy', 'details', 'develop', 'device', 'dictator', 'die',

'different', 'difficult', 'dig', 'dinner', 'diplomat', 'direct', 'direction', 'dirty', 'disappear', 'disarm', 'discover',

'discuss', 'disease', 'dismiss', 'dispute', 'dissident', 'distance', 'distant', 'dive', 'divide', 'do', 'doctor', 'document',

 'dollar', 'door', 'down', 'draft', 'dream', 'drink', 'drive', 'drown', 'drugs', 'dry', 'during', 'dust', 'duty', 'each',

'early', 'earn', 'earth', 'earthquake', 'ease', 'east', 'easy', 'eat', 'economy', 'edge', 'educate', 'effect', 'effort',

'egg', 'either', 'elect', 'electricity', 'electron', 'element', 'embassy', 'emergency', 'emotion', 'employ', 'empty', 'end',

'enemy', 'energy', 'enforce', 'engine', 'engineer', 'enjoy', 'enough', 'enter', 'eqipment', 'equal', 'escape', 'especially',

'establish', 'even', 'event', 'ever', 'every', 'evidence', 'evil', 'evironment', 'exact', 'examine', 'example', 'excellent',

 'except', 'exchange', 'excite', 'excuse', 'execute', 'exile', 'exist', 'expand', 'expect', 'expel', 'experiment', 'expert',

'explain', 'explode', 'explore', 'export', 'express', 'extend', 'extra', 'extreme', 'face', 'fact', 'factory', 'fail',

'fair', 'fall', 'family', 'famous', 'fanatic', 'far', 'farm', 'fast', 'fat', 'father', 'fear', 'feast', 'federal', 'feed',

'feel', 'female', 'fertile', 'few', 'field', 'fierce', 'fight', 'fill', 'film', 'final', 'find', 'fine', 'finish', 'fire',

'firm', 'first', 'fish', 'fix', 'flag', 'flat', 'flee', 'float', 'flood', 'floor', 'flow', 'flower', 'fluid', 'fly', 'fog',

'follow', 'food', 'fool', 'foot', 'for', 'force', 'foreign', 'forget', 'forgive', 'form', 'former', 'forward', 'free',

'freeze', 'fresh', 'friend', 'frighten', 'from', 'front', 'fruit', 'fuel', 'funeral', 'furious', 'future', 'gain', 'game',

'gas', 'gather', 'general', 'gentle', 'get', 'gift', 'girl', 'give', 'glass', 'go', 'goal', 'God', 'gold', 'good',

'good-bye', 'goods', 'govern', 'government', 'grain', 'grandfather', 'grandmother', 'grass', 'gray', 'great', 'green',

'grind', 'ground', 'group', 'grow', 'guarantee', 'guard', 'guerilla', 'guide', 'guilty', 'gun', 'hair', 'half', 'halt',

'hang', 'happen', 'happy', 'harbor', 'hard', 'harm', 'hat', 'hate', 'he', 'head', 'headquarters', 'health', 'hear', 'heart',

 'heat', 'heavy', 'helicopter', 'help', 'here', 'hero', 'hide', 'high', 'hijack', 'hill', 'history', 'hit', 'hold', 'hole',

 'holiday', 'holy', 'home', 'honest', 'honor', 'hope', 'horrible', 'horse', 'hospital', 'hostage', 'hostile', 'hostilities',

 'hot', 'hotel', 'hour', 'house', 'how', 'however', 'huge', 'human', 'humor', 'hunger', 'hunt', 'hurry', 'hurt', 'husband',

'I', 'ice', 'idea', 'if', 'illegal', 'imagine', 'immediate', 'import', 'important', 'improve', 'in', 'incident', 'incite',

'include', 'increase', 'independent', 'industry', 'inflation', 'influence', 'inform', 'injure', 'innocent', 'insane',

'insect', 'inspect', 'instead', 'instrument', 'insult', 'intelligent', 'intense', 'interest', 'interfere', 'international',

'intervene', 'invade', 'invent', 'invest', 'investigate', 'invite', 'involve', 'iron', 'island', 'issue', 'it', 'jail',

'jewel', 'job', 'join', 'joint', 'joke', 'judge', 'jump', 'jungle', 'jury', 'just', 'keep', 'kick', 'kidnap', 'kill', 'kind',

 'kiss', 'knife', 'know', 'labor', 'laboratory', 'lack', 'lake', 'land', 'language', 'large', 'last', 'late', 'laugh',

'launch', 'law', 'lead', 'leak', 'learn', 'leave', 'left', 'legal', 'lend', 'less', 'let', 'letter', 'level', 'liberal',

'lie', 'life', 'light', 'lightning', 'like', 'limit', 'line', 'link', 'liquid', 'list', 'listen', 'little', 'live', 'load',

'local', 'lonely', 'long', 'look', 'lose', 'loud', 'love', 'low', 'loyal', 'luck', 'machine', 'mad', 'mail', 'main', 'major',

 'majority', 'make', 'male', 'man', 'map', 'march', 'mark', 'marker', 'mass', 'material', 'may', 'mayor', 'mean', 'measure',

'meat', 'medicine', 'meet', 'melt', 'member', 'memorial', 'memory', 'mercenary', 'mercy', 'message', 'metal', 'method',

'microscope', 'middle', 'militant', 'military', 'milk', 'mind', 'mine', 'mineral', 'minister', 'minor', 'minority', 'minute',

 'miss', 'missile', 'missing', 'mistake', 'mix', 'mob', 'moderate', 'modern', 'money', 'month', 'moon', 'more', 'morning',

'most', 'mother', 'motion', 'mountain', 'mourn', 'move', 'much', 'murder', 'music', 'must', 'mystery', 'naked', 'name',

'nation', 'navy', 'near', 'necessary', 'need', 'negotiate', 'neither', 'nerve', 'neutral', 'never', 'new', 'news', 'next',

'nice', 'night', 'no', 'noise', 'nominate', 'noon', 'normal', 'north', 'not', 'note', 'nothing', 'now', 'nowhere', 'nuclear',

 'number', 'nurse', 'obey', 'object', 'observe', 'occupy', 'ocean', 'of', 'off', 'offensive', 'offer', 'officer', 'official',

 'often', 'oil', 'old', 'on', 'once', 'only', 'open', 'operate', 'opinion', 'oppose', 'opposite', 'oppress', 'or', 'orbit',

'orchestra', 'order', 'organize', 'other', 'oust', 'out', 'over', 'overthrow', 'owe', 'own', 'pain', 'paint', 'palace',

'pamphlet', 'pan', 'paper', 'parachute', 'parade', 'pardon', 'parent', 'parliament', 'part', 'party', 'pass', 'passenger',

'passport', 'past', 'path', 'pay', 'peace', 'people', 'percent', 'perfect', 'perhaps', 'period', 'permanent', 'permit',

'person', 'physics', 'piano', 'picture', 'piece', 'pilot', 'pipe', 'pirate', 'place', 'planet', 'plant', 'play', 'please',

'plenty', 'plot', 'poem', 'point', 'poison', 'police', 'policy', 'politics', 'pollute', 'poor', 'popular', 'population',

'port', 'position', 'possess', 'possible', 'postpone', 'pour', 'power', 'praise', 'pray', 'pregnant', 'prepare', 'present',

'president', 'press', 'pressure', 'prevent', 'price', 'priest', 'prison', 'private', 'prize', 'probably', 'problem',

'produce', 'professor', 'program', 'progress', 'project', 'promise', 'propaganda', 'property', 'propose', 'protect',

'protest', 'proud', 'prove', 'provide', 'public', 'publication', 'publish', 'pull', 'pump', 'punish', 'purchase', 'pure',

'purpose', 'push', 'put', 'question', 'quick', 'quiet', 'rabbi', 'race', 'radar', 'radiation', 'radio', 'raid', 'railroad',

'rain', 'raise', 'rapid', 'rare', 'rate', 'reach', 'read', 'ready', 'real', 'realistic', 'reason', 'reasonable', 'rebel',

'receive', 'recent', 'recession', 'recognize', 'record', 'red', 'reduce', 'reform', 'refugee', 'refuse', 'regret',

'relations', 'release', 'religion', 'remain', 'remember', 'remove', 'repair', 'repeat', 'report', 'repress', 'request',

'rescue', 'resign', 'resolution', 'responsible', 'rest', 'restrain', 'restrict', 'result', 'retire', 'return', 'revolt',

'rice', 'rich', 'ride', 'right', 'riot', 'rise', 'river', 'road', 'rob', 'rock', 'rocket', 'roll', 'room', 'root', 'rope',

'rough', 'round', 'rub', 'rubber', 'ruin', 'rule', 'run', 'sabotage', 'sacrifice', 'sad', 'safe', 'sail', 'salt', 'same',

'satellite', 'satisfy', 'save', 'say', 'school', 'science', 'scream', 'sea', 'search', 'season', 'seat', 'second', 'secret',

'security', 'see', 'seek', 'seem', 'seize', 'self', 'sell', 'senate', 'send', 'sense', 'sentence', 'separate', 'series',

'serious', 'sermon', 'serve', 'set', 'settle', 'several', 'severe', 'sex', 'shake', 'shape', 'share', 'sharp', 'she', 'shell',

'shine', 'ship', 'shock', 'shoe', 'shoot', 'short',

 'should', 'shout', 'show', 'shrink', 'shut', 'sick', 'side',

 'sign', 'signal', 'silence', 'silver', 'similar', 'simple', 'since', 'sing', 'sink', 'sister', 'sit', 'situation', 'size',

'skeleton', 'skill', 'skull', 'sky', 'slave', 'sleep', 'slide', 'slow', 'small', 'smash', 'smell', 'smile', 'smoke',

'smooth', 'snow', 'so', 'social', 'soft', 'soldier', 'solid', 'solve', 'some', 'son', 'soon', 'sorry', 'sort', 'sound',

'south', 'space', 'speak', 'special', 'speed', 'spend', 'spill', 'spilt', 'spirit', 'split', 'sports', 'spread', 'spring',

'spy', 'stab', 'stamp', 'stand', 'star', 'start', 'starve', 'state', 'station', 'statue', 'stay', 'steal', 'steam', 'steel',

'step', 'stick', 'still', 'stomach', 'stone', 'stop', 'store', 'storm', 'story', 'stove', 'straight', 'strange', 'street',

'stretch', 'strike', 'strong', 'struggle', 'stubborn', 'study', 'stupid', 'submarine', 'substance', 'substitute',

'subversion', 'succeed', 'such', 'sudden', 'suffer', 'sugar', 'summer', 'sun', 'supervise', 'supply', 'support', 'suppose',

'suppress', 'sure', 'surplus', 'surprise', 'surrender', 'surround', 'survive', 'suspect', 'suspend', 'swallow', 'swear',

'sweet', 'swim', 'sympathy', 'system', 'take', 'talk', 'tall', 'tank', 'target', 'task', 'taste', 'tax', 'teach', 'team',

'tear', 'tears', 'technical', 'telephone', 'telescope', 'television', 'tell', 'temperature', 'temporary', 'tense', 'term',

'terrible', 'territory', 'terror', 'test', 'textiles', 'than', 'thank', 'that', 'the', 'theater', 'then', 'there', 'thick',

'thin', 'thing', 'think', 'third', 'this', 'threaten', 'through', 'throw', 'tie', 'time', 'tired', 'tissue', 'to', 'today',

'together', 'tomorrow', 'tonight', 'too', 'tool', 'top', 'torture', 'touch', 'toward', 'town', 'trade', 'tradition',

'tragic', 'train', 'traitor', 'transport', 'trap', 'travel', 'treason', 'treasure', 'treat', 'treaty', 'tree', 'trial',

'tribe', 'trick', 'trip', 'troops', 'trouble', 'truce', 'truck', 'trust', 'try', 'turn', 'under', 'understand', 'unite',

'universe', 'university', 'unless', 'until', 'up', 'urge', 'urgent', 'use', 'usual', 'valley', 'value', 'vehicle', 'version',

'veto', 'vicious', 'victim', 'victory', 'village', 'violate', 'violence', 'violin', 'virus', 'visit', 'voice', 'volcano',

'vote', 'voyage', 'wages', 'wait', 'walk', 'wall', 'want', 'war', 'warm', 'warn', 'wash', 'waste', 'watch', 'water', 'wave',

'way', 'weak', 'wealth', 'weapon', 'wear', 'weather', 'weigh', 'welcome', 'well', 'west', 'wet', 'what', 'wheat', 'wheel',

'when', 'where', 'which', 'while', 'white', 'who', 'why', 'wide', 'wife', 'wild', 'will', 'willing', 'win', 'wind', 'window',

 'wire', 'wise', 'wish', 'with', 'withdraw', 'without', 'woman', 'wonder', 'wood', 'woods', 'word', 'work', 'world', 'worry',

 'worse', 'wound', 'wreck', 'write', 'wrong', 'year', 'yellow', 'yes', 'yesterday', 'yet', 'you', 'young');

    return $array;

}

//End SecurePass



function CatCount($id)

{

global $time_start;

$total = 0;



    if($id)

    {

    $catdb1 = new clsDBNetConnect;



	$n1 = 0;$n2 = 0;$n3 = 0;$n4 = 0;$n5 = 0;

	$newSQL1 = "SELECT cat_id FROM categories WHERE sub_cat_id='" . $id . "'";

	$incat = "category='" . $id . "'";

	$catdb1->query($newSQL1);

	while($catdb1->next_record())

      	{

	  	if($n1 == 0)

			{

				$sql2 = "SELECT cat_id FROM categories WHERE sub_cat_id='" . $catdb1->f(0) . "'";

			}

			else

			{

				$sql2 .= " OR sub_cat_id='" . $catdb1->f(0) . "'";

			}

        	$incat .= " OR category='" . $catdb1->f(0) . "'";

	  	$n1 = 1;

        	}

		if($n1 == 1)

	{

$catdb1->query($sql2);

while($catdb1->next_record())

	{

	  if($n2 == 0)

		{

		$sql3= "SELECT cat_id FROM categories WHERE sub_cat_id='" . $catdb1->f(0) . "'";

		}

		else

		{

		$sql3 .= " OR sub_cat_id='" . $catdb1->f(0) . "'";

		}

        $incat .= " OR category='" . $catdb1->f(0) . "'";

	  $n2 = 1;

        }

}

if($n2 == 1)

{

$catdb1->query($sql3);

while($catdb1->next_record())

	{

	  if($n3 == 0)

		{

		$sql4= "SELECT cat_id FROM categories WHERE sub_cat_id='" . $catdb1->f(0) . "'";

		}

		else

		{

		$sql4 .= " OR sub_cat_id='" . $catdb1->f(0) . "'";

		}

        $incat .= " OR category='" . $catdb1->f(0) . "'";

	  $n3 = 1;

        }

}

if($n3 == 1)

{

$catdb1->query($sql4);

while($catdb1->next_record())

	{

	  if($n4 == 0)

		{

		$sql5= "SELECT cat_id FROM categories WHERE sub_cat_id='" . $catdb1->f(0) . "'";

		}

		else

		{

		$sql5 .= " OR sub_cat_id='" . $catdb1->f(0) . "'";

		}

        $incat .= " OR category='" . $catdb1->f(0) . "'";

	  $n4 = 1;

        }

}

if($n4 == 1)

{

$catdb1->query($sql5);

while($catdb1->next_record())

	{

	  $incat .= " OR category='" . $catdb1->f(0) . "'";

      }



}

    $ctdb = new clsDBNetConnect;

    $ctdb->connect();

    $total = CCDLookUp("COUNT(category)","items", "(" . $incat . ") AND status='1'", $ctdb);

    //$total = $ctdb->f(0);

    }

    return $total;

	

}

//Plugin Replacement Plain Arrays

function ReplacePA($str,$art)

{

      if($nr1=strpos($str,'['))

      {

        $tr=substr($str,0,$nr1);

        $nr2=strpos($str,']',$nr1);

        $tr.=$art[substr($str,$nr1+1,$nr2-$nr1-1)];

        $tr.=substr($str,$nr2+1);

        return ReplacePA($tr,$art);

      }

      else

      {

        $OUT = explode("76PULL*PULL76", $str);

        return $OUT[1];

      }

}

//Plugin Replacement Class Arrays

function ReplaceCA($str,$art)

{

      if($nr1=strpos($str,'['))

      {

        $tr=substr($str,0,$nr1);

        $nr2=strpos($str,']',$nr1);

        $repl = substr($str,$nr1+1,$nr2-$nr1-1);

                $tr.=$art->$repl->Value;

        $tr.=substr($str,$nr2+1);



        return ReplaceCA($tr,$art);

      }

      else

      {

        return $str;

      }

}

function moveFile($tmpfile) {



       $tmpdir = "temp/";

       $uploaddir = $now["uploadurl"];



       $filename = str_replace($tmpdir, "", $tmpfile);

       $newfile = $uploaddir . $filename;       if(copy($tmpfile, $newfile)) {

            unlink($tmpfile);

            return $filename;

       }



       return 0;



}

function thumbnail($img,$w,$h,$mode,$use){

        global $now;

//$img = $now["uploadurl"] . $img;

if (!isset($w))

    {

    $w = 50;

    }



if (!isset($h))

    {

    $h = 50;

    }SetType($mode,   'integer');

SetType($w,      'integer');

SetType($h,     'integer');

SetType($img,     'string' );// Initialization



// Make sure the file exists...

if (!file_exists($img))

    {

    //echo "Error: could not find file: $img.";

    //exit();

    }



// If the user defined a type to use.

if (!isset($type))

    {

    $ext = explode('.', $img);

    $ext = $ext[count($ext)-1];

        switch(strtolower($ext))

            {

            case 'jpeg'  :

                $type = 'jpg';

            break;

            default :

                $type = $ext;

            break;

            }

    }



// Create the image...

switch (strtolower($type))

    {

    case 'jpg':

        $tmpgif = @GetImageSize($img);

    break;



    case 'gif':

        $tmpgif = @GetImageSize($img);

    break;



    case 'png':

        $tmp = @GetImageSize($img);

    break;



    default:

        //echo 'Error: Unrecognized image format.';

        //exit();

    break;

    }



if($tmpgif)

    {

    // Resize it



    $ow  = $tmpgif[0];    // Original image width

    $oh  = $tmpgif[1];    // Original image height



    if ($mode)

        {

        // Just smash it up to fit the dimensions

        $nw = $w;

        $nh = $h;

        }

    else

        {

        // Make it proportional.

        if ($ow > $oh AND ($ow > $w OR $oh > $h))

            {

            $nw  = $w;

            $nh = unpercent(newpercent($nw, $ow), $oh);

            }

      else if ($oh > $ow AND ($ow > $w OR $oh > $h))

            {

            $nh = $h;

            $nw = unpercent(newpercent($nh, $oh), $ow);

            }

      else if ($oh == $ow AND ($ow > $w OR $oh > $h))

		{

		$nh = $h;

		$nw = $w;

		} 

	else

            {

            $nh = $oh;

            $nw = $ow;

            }

        }



        if($use == 0){

                $out = "<img src=\"$img\" height=\"$nh\" width=\"$nw\" border=\"0\" name=\"slideshow\">";

        }

        if($use == 1){

                $out = $img . "^" . $nh . "^" . $nw;

        }

    }

else

    {

    //echo 'Could not create image resource.';

    //exit;

    }if ($out)

    {

    return $out;

    //imagedestroy($out);

    }

else

    {

    //echo 'ERROR: Could not create resized image.';

    }

}

function newpercent($p, $w)

    {

    return (real)(100 * ($p / $w));

    }



function unpercent($percent, $whole)

    {

    return (real)(($percent * $whole) / 100);

    }//Initialize System Variables

$db = new clsDBNetConnect();

$SQL = "SELECT * FROM settings_general WHERE set_id='1'";

$db->query($SQL);

$Result = $db->next_record();

if($Result)

    {

        $now = array(

        "sitename"       => $db->f("sitename"),

        "siteemail"      => $db->f("siteemail"),

        "homeurl"        => $db->f("homeurl"),

        "secureurl"      => $db->f("secureurl"),

        "uploadurl"      => $db->f("uploadurl"),

        "pagentrys"      => $db->f("pagentrys"),

        "frontentrys"    => $db->f("frontentrys"),

        "notify"         => $db->f("notify"),

        "notifyads"      => $db->f("notifyads"),

        "notifyemail"    => $db->f("notifyemail"),

	  "bounceout"      => $db->f("bounceout"),

	  "bouceout_id"    => $db->f("bounceout_id"),

        "timeout"        => $db->f("timeout"),

        "demographics"        => $db->f("demographics"),

        "approv_priority"        => $db->f("approv_priority"),

        "has_gd"        => $db->f("has_gd"),

        "mimemail"        => $db->f("mimemail")

        );

    }



unset($db);

unset($SQL);

unset($Result);

//End Initialize System Variables



//Initialize Accounting Variables

$db = new clsDBNetConnect();

$SQL = "SELECT * FROM settings_accounting WHERE set_id='1'";

$db->query($SQL);

$Result = $db->next_record();

if($Result)

    {

        $accounting = array(

        "paypal_on"                  => $db->f("paypal_on"),

        "paypal"                     => $db->f("paypal"),

        "authorize_on"               => $db->f("authorizenet_on"),

        "authorize"                  => $db->f("authorizenet"),

	"authorize_tran_key"         => $db->f("authorize_tran_key")

        );

    }



unset($db);

unset($SQL);

unset($Result);

//End Initialize Accounting Variables



//Initialize Charges Variables

$db = new clsDBNetConnect();

if ($_GET["cat_id"])

	$cat_id = $_GET["cat_id"];

elseif ($_GET["finalcat"])

    $cat_id = $_GET["finalcat"];

elseif ($_POST["finalcat"])

    $cat_id = $_POST["finalcat"];

elseif ($_POST["category"])

	$cat_id = $_POST["category"];

elseif ($_POST["cat"])

	$cat_id = $_POST["cat"];

elseif ($_GET["PreviewNum"]){

	$db = new clsDBNetConnect;

	$query = "select `category` from items_preview where `ItemNum`='" . $_GET["PreviewNum"] . "'";

	$db->query($query);

	if ($db->next_record()){

		$cat_id = $db->f("category");

	} else {

		$cat_id = 1;

	}

}

elseif (CCGetSession("RecentItemNum")){

	$db = new clsDBNetConnect;

	$query = "select `category` from items where `ItemNum`='" . CCGetSession("RecentItemNum") . "'";

	$db->query($query);

	if ($db->next_record()){

		$cat_id = $db->f("category");

	} else {

		$cat_id = 1;

	}

}

else

    $cat_id = 1;

$cat_id = getparents_charges($cat_id);

$SQL = "SELECT * FROM settings_charges WHERE set_id='" . $cat_id . "'";

$db->query($SQL);

$Result = $db->next_record();

if($Result)

    {

        $charges = array(

        "currency"      => $db->f("currency"),

	  "currencycode"  => $db->f("currencycode"),

        "listing_fee"   => $db->f("listing_fee"),

        "home_fee"      => $db->f("home_fee"),

        "cat_fee"       => $db->f("cat_fee"),

        "gallery_fee"   => $db->f("gallery_fee"),

        "image_pre_fee" => $db->f("image_pre_fee"),

        "slide_fee"     => $db->f("slide_fee"),

        "counter_fee"   => $db->f("counter_fee"),

        "bold_fee"      => $db->f("bold_fee"),

        "high_fee"      => $db->f("high_fee"),

        "upload_fee"   => $db->f("upload_fee")

        );

	  $Give_New_Credit = $db->f("newregon");

        $Give_Amount = $db->f("newregcredit");

        $Give_Tokens = $db->f("tokens");

        $Give_Cause = $db->f("newregreason");



    }

if ($cat_id != 1){

	$SQL = "SELECT * FROM settings_charges WHERE set_id=1";

	$db->query($SQL);

	if($db->next_record()){

		$charges["currency"] = $db->f("currency");

	  	$charges["currencycode"] = $db->f("currencycode");

	  $Give_New_Credit = $db->f("newregon");

        $Give_Amount = $db->f("newregcredit");

        $Give_Tokens = $db->f("tokens");

        $Give_Cause = $db->f("newregreason");



    }

}

	

$regcharges = $charges;

unset($db);

unset($SQL);

unset($Result);

//End Initialize Charges Variables



//Initialize Images Variables

$db = new clsDBNetConnect();

$SQL = "SELECT * FROM settings_images WHERE set_id='1'";

$db->query($SQL);

$Result = $db->next_record();

if($Result)

    {

        $images = array(

        "maxuploadwidth"  => $db->f("maxuploadwidth"),

                "maxuploadheight" => $db->f("maxuploadheight")

        );

    }



unset($db);

unset($SQL);

unset($Result);

//End Initialize Images Variables// Begin Mail Function

                $lookdb = new clsDBNetConnect;

                $lookdb->connect();

                if(CCGetUserID()) {

                        $lookdb->query("SELECT * FROM users WHERE user_id='" . CCGetUserID() . "'");

                        if($lookdb->next_record()) {

                        $ld = array(

                        "first" => $lookdb->f("first_name"),

                        "last" => $lookdb->f("last_name"),

                        "email" => $lookdb->f("email"),

                        "address" => $lookdb->f("address1"),

                        "address2" => $lookdb->f("address2"),

                        "state" => $lookdb->f("state_id"),

                        "zip" => $lookdb->f("zip"),

                        "city" => $lookdb->f("city"),

                        "phonedy" => $lookdb->f("phone_day"),

                        "phoneevn" => $lookdb->f("phone_evn"),

                        "fax" => $lookdb->f("fax"),

                        "ip" => $lookdb->f("ip_insert"),

                        "date_created" => $lookdb->f("date_created"),

                        );

                        }

                }

                $PP = array(

                "PAGE:SITE_NAME" => $now["sitename"],

                "PAGE:SITE_EMAIL" => $now["siteemail"],

                "PAGE:SITE_EMAIL_LINK" => "<a href=\"mailto:" . $now["siteemail"] . "\">" . $now["siteemail"] . "</a>",

                "PAGE:HOME_URL" => $now["homeurl"],

                "PAGE:HOME_PAGE_LINK" => "<a href=\"" . $now["homeurl"] . "index.php\">Home</a>",

                "PAGE:BROWSE_LINK" => "<a href=\"" . $now["homeurl"] . "browse.php\">Browse</a>",

                "PAGE:SEARCH_LINK" => "<a href=\"" . $now["homeurl"] . "search.php\">Search</a>",

                "PAGE:MY_ACCOUNT_LINK" => "<a href=\"" . $now["homeurl"] . "myaccount.php\">My Account</a>",

                "PAGE:PAYMENT_LINK_SSL" => "<a href=\"" . $now["secureurl"] . "MakePayment.php\">Make a Payment</a>",

                "PAGE:PAYMENT_LINK" => "<a href=\"" . $now["homeurl"] . "MakePayment.php\">Make a Payment</a>",

                "PAGE:CURRENCY" => $charges["currency"],

                "PAGE:LISTING_FEE" => $charges["listing_fee"],

                "PAGE:HOMEPAGE_FEATURED_FEE" => $charges["homepage_fee"],

                "PAGE:CATEGORY_FEATURED_FEE" => $charges["category_fee"],

                "PAGE:GALLERY_FEE" => $charges["gallery_fee"],

                "PAGE:IMAGE_PREVIEW_FEE" => $charges["image_preview_fee"],

                "PAGE:SLIDE_SHOW_FEE" => $charges["slide_fee"],

                "PAGE:COUNTER_FEE" => $charges["counter_fee"],

                "PAGE:BOLD_FEE" => $charges["bold_fee"],

                "PAGE:BACKGROUND_FEE" => $charges["highlight_fee"],

                "PAGE:IMAGE_UPLOAD_FEE" => $charges["upload_fee"],

                "PAGE:CURRENT_TIME" => date("F j, Y, g:i a"),

                "PAGE:CURRENT_USERNAME" => CCGetUserName(),

                "PAGE:CURRENT_USERID" => CCGetUserID(),

                "PAGE:CURRENT_USER_FIRST_NAME" => $ld["first"],

                "PAGE:CURRENT_USER_LAST_NAME" => $ld["last"],

                "PAGE:CURRENT_USER_EMAIL" =>  $ld["email"],

                "PAGE:CURRENT_USER_ADDRESS" => $ld["address"],

                "PAGE:CURRENT_USER_ADDRESS2" => $ld["address2"],

                "PAGE:CURRENT_USER_STATE" => $ld["state"],

                "PAGE:CURRENT_USER_CITY" => $ld["city"],

                "PAGE:CURRENT_USER_ZIP" => $ld["zip"],

                "PAGE:CURRENT_USER_DAY_PHONE" => $ld["phonedy"],

                "PAGE:CURRENT_USER_EVN_PHONE" => $ld["phoneevn"],

                "PAGE:CURRENT_USER_FAX" => $ld["fax"],

                "PAGE:CURRENT_USER_IP" => getenv("REMOTE_ADDR"),

                "PAGE:CURRENT_USER__REGISTERED_IP" => $ld["ip"],

                "PAGE:CURRENT_USER_DATE_SIGNEDUP" => date("F j, Y, g:i a", $ld["date_created"])

                );

                $EP = array(

                "EMAIL:SITE_NAME" => $now["sitename"],

                "EMAIL:SITE_EMAIL" => $now["siteemail"],

                "EMAIL:SITE_EMAIL_LINK" => "<a href=\"mailto:" . $now["siteemail"] . "\">" . $now["siteemail"] . "</a>",

                "EMAIL:HOME_URL" => $now["homeurl"],

                "EMAIL:HOME_PAGE_LINK" => "<a href=\"" . $now["homeurl"] . "index.php\">Home</a>",

                "EMAIL:BROWSE_LINK" => "<a href=\"" . $now["homeurl"] . "browse.php\">Browse</a>",

                "EMAIL:SEARCH_LINK" => "<a href=\"" . $now["homeurl"] . "search.php\">Search</a>",

                "EMAIL:MY_ACCOUNT_LINK" => "<a href=\"" . $now["homeurl"] . "myaccount.php\">My Account</a>",

                "EMAIL:PAYMENT_LINK_SSL" => "<a href=\"" . $now["secureurl"] . "MakePayment.php\">Make a Payment</a>",

                "EMAIL:PAYMENT_LINK" => "<a href=\"" . $now["homeurl"] . "MakePayment.php\">Make a Payment</a>",

                "EMAIL:CURRENCY" => $charges["currency"],

                "EMAIL:LISTING_FEE" => $charges["listing_fee"],

                "EMAIL:HOMEPAGE_FEATURED_FEE" => $charges["homepage_fee"],

                "EMAIL:CATEGORY_FEATURED_FEE" => $charges["category_fee"],

                "EMAIL:GALLERY_FEE" => $charges["gallery_fee"],

                "EMAIL:IMAGE_PREVIEW_FEE" => $charges["image_preview_fee"],

                "EMAIL:SLIDE_SHOW_FEE" => $charges["slide_fee"],

                "EMAIL:COUNTER_FEE" => $charges["counter_fee"],

                "EMAIL:BOLD_FEE" => $charges["bold_fee"],

                "EMAIL:BACKGROUND_FEE" => $charges["highlight_fee"],

                "EMAIL:IMAGE_UPLOAD_FEE" => $charges["upload_fee"],

                "EMAIL:CURRENT_TIME" => date("F j, Y, g:i a")

                );

function mailout($name, $notify, $touser, $fromuser, $dtime, $EP)

{

      global $now;

      global $accounting;

      global $charges;



      if($fromuser=="None")

      {

       $fromuser = 1000000000;

      }

      $tempdb = new clsDBNetConnect;

      $tempdb->connect();

      $tempdb2 = new clsDBNetConnect;

      $tempdb2->connect();

      $tempdb3 = new clsDBNetConnect;

      $tempdb3->connect();

      $tempdb4 = new clsDBNetConnect;

      $tempdb4->connect();

      $tempdb5 = new clsDBNetConnect;

      $tempdb5->connect();

      $tempdb->query("SELECT email_subject, email_text FROM templates_emails WHERE template_name='" . $name . "'");

      if($tempdb->next_record())

      {

      $tempsub = "process76PULL*PULL76" . $tempdb->f(0);

      $tempmes = "process76PULL*PULL76" . $tempdb->f(1);

      $newmessage = ReplacePA($tempmes, $EP);

      $newsubject = ReplacePA($tempsub, $EP);

      $tempdb4->query("INSERT INTO emails (to_user_id, from_user_id, emaildate, subject, message) VALUES ('" . $touser . "', '" . $fromuser . "', '" . $dtime . "', '" . addslashes($newsubject) . "', '" . addslashes($newmessage) . "')");

      }

      unset($tempdb);

      $tempdb2->query("SELECT email_subject, email_text FROM templates_emails WHERE template_name='" . $name . "Notification'");

      if($tempdb2->next_record())

      {

      $tempsub2 = "process76PULL*PULL76" . $tempdb2->f(0);

      $tempmes2 = "process76PULL*PULL76" . $tempdb2->f(1);

      $mailsubject = ReplacePA($tempsub2, $EP);

      $mailmessage = ReplacePA($tempmes2, $EP);

      $to = CCDLookUp("email", "users", "user_id='" . $touser . "'", $tempdb5);

      $subject = $mailsubject;

      $message = $mailmessage;

      $from = $now["siteemail"];

      $fromname = $now["sitename"];

      if ($now["mimemail"] == "1") {

      	include('htmlMimeMail/htmlMimeMail.php');

      	$mail = new htmlMimeMail();

      	$mail->setReturnPath($from);

      	$mail->setFrom("\"" . $fromname . "\" <$from>");

      	$mail->setSubject($subject);

      	$mail->setHeader('X-Mailer', 'HTML Mime mail class (http://www.phpguru.org)');

      	$mail->setText($message);

      	$result = $mail->send(array($to), 'smtp');

      } else {

      	$additional_headers = "From: \"$fromname\" <$from>\nReply-To: $from\n" . "X-Mailer: $fromname Email Notifier (" . $now["homeurl"] . ")";

      	@mail ($to, $subject, $message, $additional_headers);

      }

      unset($tempdb2);

      }

      if($notify == 1)

      {

         $tempdb3->query("SELECT email_subject, email_text FROM templates_emails WHERE template_name='" . $name . "AdminCopy'");

         if($tempdb3->next_record())

         {

         $tempsub3 = "process76PULL*PULL76" . $tempdb3->f(0);

         $tempmes3 = "process76PULL*PULL76" . $tempdb3->f(1);

         $mailsubject = ReplacePA($tempsub3, $EP);

         $mailmessage = ReplacePA($tempmes3, $EP);

         $to = $now["notifyemail"];

         $subject = $mailsubject;

         $message = $mailmessage;

         $from = $now["siteemail"];

         $fromname = $now["sitename"];

      	 if ($now["mimemail"] == "1") {

         	$mail = new htmlMimeMail();

      	 	$mail->setReturnPath($from);

      	 	$mail->setFrom("\"" . $fromname . "\" <$from>");

      	 	$mail->setSubject($subject);

      	 	$mail->setHeader('X-Mailer', 'HTML Mime mail class (http://www.phpguru.org)');

	     	$mail->setText($message);

      	 	$result = $mail->send(array($to), 'smtp');

      	 } else {

         	$additional_headers = "From: \"$fromname\" <$from>\nReply-To: $from\n" . "X-Mailer: $fromname Email Notifier (" . $now["homeurl"] . ")";

         	@mail ($to, $subject, $message, $additional_headers);

      	 }

         }

         unset($tempdb3);

      }

}

// End Mail Function



function pode($feat, $fee)

{

         if($feat==1)

         {

         $out = $fee;

         }

         if($feat==0)

         {

         $out = "Not Selected";

         }

         return $out;

}



function podeimg($img, $fee)

{

         if($img != "")

         {

         $out = $fee;

         }

         else

         {

         $out = "No Image Uploaded";

         }

         return $out;

}



//Begin Code to expire and and delete expired listing and images

if($config_autocron) {

$FindAll = new clsDBNetConnect;

$FindAll->connect();

$FindSQL = "SELECT * FROM items WHERE closes<'" . time() . "' AND status='1'";

$FindAll->query($FindSQL);

$Closer = new clsDBNetConnect;

$Closer->connect();

while($FindAll->next_record())

{

    $Closer->query("UPDATE items SET status='2' WHERE itemID='" . $FindAll->f("itemID") . "'");

    subtract_catcounts($FindAll->f("category"));

    $Closer->query("DELETE FROM listing_index WHERE ItemNum='" . $FindAll->f("ItemNum") . "'");

}

$old = new clsDBNetConnect;

$old->connect();

$oldtime = time() - (86400 * 30);

$sql = "SELECT * FROM items WHERE closes <'" . $oldtime . "' AND status!='1'";

$old->query($sql);

$del = new clsDBNetConnect;

$del->connect();

while($old->next_record())

{

     @unlink($old->f("image_one"));

     @unlink($old->f("image_two"));

     @unlink($old->f("image_three"));

     @unlink($old->f("image_four"));

     @unlink($old->f("image_five"));

     $del->query("DELETE FROM items WHERE itemID='" . $old->f("itemID") . "'");

     $del->query("DELETE FROM custom_textarea_values WHERE ItemNum='" . $old->f("ItemNum") . "'");

     $del->query("DELETE FROM custom_textbox_values WHERE ItemNum='" . $old->f("ItemNum") . "'");

     $del->query("DELETE FROM custom_dropdown_values WHERE ItemNum='" . $old->f("ItemNum") . "'");

     $del->query("DELETE FROM listing_index WHERE ItemNum='" . $old->f("ItemNum") . "'");

}

}





//////////////////////////////////////////////

// Execute this Code on each run of common.php

//////////////////////////////////////////////

$db = new clsDBNetConnect;

$query = "select * from used_subscriptions where active='1' and expires<'" . time() . "'";

$db->query($query);

while ($db->next_record()){

	endsubscription($db->f("id"));

}



if ($notify_time){

$time = time();

$notify_time = $notify_time * 60 * 60 * 24;

$notified = $time-$notify_time;

$closes = $time+$notify_time;

$notify = new clsDBNetConnect;

$notify->connect();

$query = "select * from items where closes<" . $closes . " and closes>" . $time . " and (notified < " . $notified . " or notified is NULL) and status=1";

$notify->query($query);

global $EP;

while ($notify->next_record()){

    $itemdata = new clsDBNetConnect;

    $itemdata->connect();

    $query = "update items set notified=" . time() . " where ItemNum=" . $notify->f("ItemNum");

    $itemdata->query($query);

    $EP["EMAIL:EXPIRE"] = date("M dS \\a\\t g:i a", $notify->f("closes"));

    $EP["EMAIL:ITEM_TITLE"] = $notify->f("title");

    $EP["EMAIL:ITEM_NUMBER"] = $notify->f("ItemNum");

mailout("NotifyRenew", $now["notify"], $notify->f("user_id"), 1000000000, time(), $EP);

}

}





////////////////////////////////////

// Search Notifications Section ////

global $now;

global $EP;

$query = "select * from search_history where `sched` = '1' and `nextrun` <= '" . time() . "'";

$db->query($query);

while ($db->next_record()){

	$addedwhere = "";

	$shownew = "";

	$Criterion = "";

	  	$array = explode(" :!:!:: ", $db->f("value"));

   		$i = 0;

   		while ($array[$i]){

			$temp = explode(" ::!:!: ", $array[$i]);

    		$terms[$temp[0]] = $temp[1];

        	$i++;

        	if (strstr($temp[0], "custtxt_area::")){

        		if ($temp[1])

        			$custtxt_area[ltrim(end(explode("::", $temp[0])))] = $temp[1];

        	}

        	if (strstr($temp[0], "custtxt_box::")){

        		if ($temp[1])

        			$custtxt_box[ltrim(end(explode("::", $temp[0])))] = $temp[1];

        	}

        	if (strstr($temp[0], "custddbox::")){

        		if ($temp[1])

        			$custddbox[ltrim(end(explode("::", $temp[0])))] = $temp[1];

        	}

		}

		if (strlen(ltrim($db->f("results"))) > 5){

			$shownew = " and (";

			$array = "";

			$array = explode(" :!:!:: ", $db->f("results"));

   			$i = 0;

   			while ($array[$i]){

				$temp = explode(" ::!:!: ", $array[$i]);

				if (strlen(ltrim($temp[0])) > 6)

    			$shownew .= "ItemNum != " . $temp[0];

        		$i++;

        		if ($array[$i] && strlen(ltrim($temp[0])) > 6)

        			$shownew .= " and ";

        		elseif (!$array[$i])

        			$shownew .= ")";

			}

			$shownew = str_replace(" and )", ")", $shownew);

		}

		if ($terms){	



				$catdb1 = new clsDBNetConnect;

                $newSQL1 = "SELECT cat_id FROM categories WHERE sub_cat_id='" . $terms["CatID"] . "'";

                $incat = "'" . $terms["CatID"] . "'";

                $catdb1->query($newSQL1);

                while($catdb1->next_record()){

                        $incat .= " OR category='" . $catdb1->f(0) . "'";

                        $catdb2 = new clsDBNetConnect;

                        $newSQL2 = "SELECT cat_id FROM categories WHERE sub_cat_id='" . $catdb1->f(0) . "'";

                        $catdb2->query($newSQL2);

                        while($catdb2->next_record()){

                                $incat .= " OR category='" . $catdb2->f(0) . "'";

                                $catdb3 = new clsDBNetConnect;

                                $newSQL3 = "SELECT cat_id FROM categories WHERE sub_cat_id='" . $catdb2->f(0) . "'";

                                $catdb3->query($newSQL3);

                                while($catdb3->next_record()){

                                        $incat .= " OR category='" . $catdb3->f(0) . "'";

                                        $catdb4 = new clsDBNetConnect;

                                        $newSQL4 = "SELECT cat_id FROM categories WHERE sub_cat_id='" . $catdb3->f(0) . "'";

                                        $catdb4->query($newSQL4);

                                        while($catdb4->next_record()){

                                                $incat .= " OR category='" . $catdb4->f(0) . "'";

                                                $catdb5 = new clsDBNetConnect;

                                                $newSQL5 = "SELECT cat_id FROM categories WHERE sub_cat_id='" . $catdb4->f(0) . "'";

                                                $catdb5->query($newSQL5);

                                                while($catdb5->next_record()){

                                                        $incat .= " OR category='" . $catdb5->f(0) . "'";

                                                }

                                        }

                                }

                        }

                }

                

				if ($terms["s_indexsearch"]){

    				$addedwhere = index_search($terms["s_indexsearch"]);

    				if (strlen($addedwhere) > 5)

	    				$addedwhere = " and (" . $addedwhere . ")";

    				else 

	    				$addedwhere = " and (ItemNum = -1)";

    			}

    			if (is_array($custtxt_area) && $addedwhere != " and (ItemNum = -1)"){

    				$i = 0;

    				$keys = array_keys($custtxt_area);

    				foreach ($custtxt_area as $val){

    					$addedwhere = searchcustom($val, "ta", $keys[$i], $addedwhere);

    					$i++;

    					if (strlen($addedwhere) > 5)

    						$addedwhere = " and (" . $addedwhere . ")";

    					else

    						$addedwhere = " and (ItemNum = -1)";

    				}

    			}

    			if (is_array($custtxt_box) && $addedwhere != " and (ItemNum = -1)"){

    				$i = 0;

    				$keys = array_keys($custtxt_box);

    				foreach ($custtxt_box as $val){

    					$addedwhere = searchcustom($val, "tb", $keys[$i], $addedwhere);

    					$i++;

    					if (strlen($addedwhere) > 5)

    						$addedwhere = " and (" . $addedwhere . ")";

    					else

    						$addedwhere = " and (ItemNum = -1)";

    				}

    			}

    			if (is_array($custddbox) && $addedwhere != " and (ItemNum = -1)"){

    				$i = 0;

    				$keys = array_keys($custddbox);

    				foreach ($custddbox as $val){

    					$addedwhere = searchcustom($val, "dd", $keys[$i], $addedwhere);

    					$i++;

    					if (strlen($addedwhere) > 5)

    						$addedwhere = " and (" . $addedwhere . ")";

    					else

    						$addedwhere = " and (ItemNum = -1)";

    				}

    			}

    			$Criterion = "";

				$Criterion .= " status='1' ";

				if ($terms["s_title"])

					$Criterion .= " and `title` like '%" . $terms["s_title"] . "%'";

				if ($terms["s_description"])

        			$Criterion .= " and `description` like '%" . $terms["s_description"] . "%'";

        		if ($terms["s_ItemNum"])

        			$Criterion .= " and `ItemNum` = '" . $terms["s_ItemNum"] . "'";

        		if ($terms["s_user_id"])

        			$Criterion .= " and `user_id` = '" . $terms["s_user_id"] . "'";

        		if ($terms["s_asking_price"])

        			$Criterion .= " and `asking_price` >= '" . $terms["s_asking_price"] . "'";

        		if ($terms["s_asking_price"])

        			$Criterion .= " and `asking_price` <= '" . $terms["s_asking_price"] . "'";

        		if ($terms["s_make_offer"])

        			$Criterion .= " and `make_offer` = '" . $terms["s_make_offer"] . "'";

        		if ($terms["s_quantity"])

        			$Criterion .= " and `quantity` >= '" . $terms["s_quantity"] . "'";

        		if ($terms["s_city_town"])

        			$Criterion .= " and `city_town` like '%" . $terms["s_city_town"] . "%'";

        		if ($terms["s_state_province"])

        			$Criterion .= " and `state_province` like '%" . $terms["s_state_province"] . "%'";

                    $Criterion .= " and (category = " . $incat . ")";

        	}

        	$query = "select * from items where " . $Criterion . $addedwhere . $shownew;

        	$db2 = new clsDBNetConnect;

        	$db2->query($query);

        	while($db2->next_record()){

        		$resultstring .= $db2->f("ItemNum") . " ::!:!: " . $db2->f("title") . " :!:!:: ";

        		$emailstring .= "<a href=\"" . $now["homeurl"] . "ViewItem.php?ItemNum=" . $db2->f("ItemNum") . "\">" . $db2->f("ItemNum") . " - " . $db2->f("title") . "<br>";

        	}

        	$frequency = $db->f("frequency");

        	$nextrun = 86400 * $frequency;

			$nextrun = $nextrun + time();

        	$db2->query("update search_history set `results` = '" . mysql_escape_string($db->f("results") . " " . $resultstring) . "', `nextrun` = '" . $nextrun . "' where `id` = '" . $db->f("id") . "'");

        	if ($resultstring){

        		$EP["EMAIL:SS_DATE"] = date("F j, Y, g:i a", $db->f("date"));

        		$EP["EMAIL:NEW_MATCHES"] = $emailstring;

        		mailout("SearchNotify", 0, $db->f("user_id"), 1000000000, time(), $EP);

        	}

        }

// End Search Notifications Section //

//////////////////////////////////////



$deltime = time() - 172800;

$query = "delete from search_history where `save` IS NULL and `date` <= '" . $deltime . "'";

$db->query($query);













////////////////////////////////////

// End Each Run section

////////////////////////////////////

function multiline($string) {

	if (strlen($string)>39){

		$word = explode(" ", $string);

		$count = 0;

		$line = "";

		$length = 0;

		while ($word[$count]){

			$line .= $word[$count] . " ";

			if ((strlen($line)-$length)>25){

				$line .= "<br>";

				$length = $length + strlen($line);

			}

			$count++;

		}

		return $line;

	}

	else {

		return $string;

	}

}



function getparents_charges($CatID){

	$cats = "(";

	$db = new clsDBNetConnect();

	$query = "select * from categories where cat_id='" .$CatID . "'";

	$db->query($query);

    $db->next_record();

    $cats .= "set_id=" . $db->f("cat_id");

    if ($db->f("sub_cat_id")){

    	$cats .= " or ";

    	$sub = $db->f("sub_cat_id");

    	$query = "select * from categories where cat_id=$sub";

    	$db->query($query);

    	$db->next_record();

    	$cats .= "set_id=" . $db->f("cat_id");

    	if ($db->f("sub_cat_id")){

    		$cats .= " or ";

    		$sub = $db->f("sub_cat_id");

    		$query = "select * from categories where cat_id=$sub";

    		$db->query($query);

    		$db->next_record();

    		$cats .= "set_id=" . $db->f("cat_id");

    		if ($db->f("sub_cat_id")){

    			$cats .= " or ";

    			$sub = $db->f("sub_cat_id");

    			$query = "select * from categories where cat_id=$sub";

    			$db->query($query);

    			$db->next_record();

    			$cats .= "set_id=" . $db->f("cat_id");

    			if ($db->f("sub_cat_id")){

    				$cats .= " or ";

    				$sub = $db->f("sub_cat_id");

    				$query = "select * from categories where cat_id=$sub";

    				$db->query($query);

    				$db->next_record();

    				$cats .= "set_id=" . $db->f("cat_id") . ")";

    			} else{

    		    	$cats .= ")";

    			}

    		} else{

    		    $cats .= ")";

    		}

    	} else{

    		$cats .= ")";

    	}

    } else{

    	$cats .= ")";

    }

    $query = "select * from settings_charges where $cats ORDER BY set_id DESC limit 1";

    $db->query($query);

	if ($db->next_record())

	    $cat = $db->f("set_id");

    else

        $cat = 1;



	return $cat;

}



function groupmemberships() {



	$user_id = CCGetUserID();

	$groups = new clsDBNetConnect;

	$query = "select distinct g.title from groups g, groups_users gu where gu.user_id='" . $user_id . "' and g.id=gu.group_id";

	$groups->query($query);

	while ($groups->next_record()){

		$return[] = $groups->f("title");

	}

	return $return;

}



function groupApprovalSpec() {



	$user_id = CCGetUserID();

	$groups = new clsDBNetConnect;

	$query = "select distinct g.req_approval from groups g, groups_users gu where gu.user_id='" . $user_id . "' and g.id=gu.group_id";

	$groups->query($query);

	while ($groups->next_record()){

		if ($groups->f("req_approval") == 1){

			$return["required"] = TRUE;

		}

		if ($groups->f("req_approval") == 0){

			$return["notrequired"] = TRUE;

		}

	}

	return $return;

}



function check_cat_permission($cat)

{

	global $valid;

	if ($valid || in_array("SuperUser", groupmemberships()))

		return 1;

	else {

		$groups = new clsDBNetConnect;

		$sql = "select * from categories where cat_id = '" . $cat . "'";

 		$groups->query($sql);

    	$groups->next_record();

    	if ($groups->f("sub_cat_id") > 1) {

    		$cat = $groups->f("sub_cat_id");

    		$sql = "select * from categories where cat_id = '" . $groups->f("sub_cat_id") . "'";

 			$groups->query($sql);

    		$groups->next_record();

    		if ($groups->f("sub_cat_id") > 1) {

    			$cat = $groups->f("sub_cat_id");

	    		$sql = "select * from categories where cat_id = '" . $groups->f("sub_cat_id") . "'";

	 			$groups->query($sql);

	    		$groups->next_record();

	    	    if ($groups->f("sub_cat_id") > 1) {

	    	    	$cat = $groups->f("sub_cat_id");

	    			$sql = "select * from categories where cat_id = '" . $groups->f("sub_cat_id") . "'";

	 				$groups->query($sql);

	    			$groups->next_record();

	    			if ($groups->f("sub_cat_id") > 1) {

	    				$cat = $groups->f("sub_cat_id");

    					$sql = "select * from categories where cat_id = '" . $groups->f("sub_cat_id") . "'";

 						$groups->query($sql);

    					$groups->next_record();

    	    			if ($groups->f("sub_cat_id") > 1) {

							$cat = $groups->f("sub_cat_id");

    						$sql = "select * from categories where cat_id = '" . $groups->f("sub_cat_id") . "'";

	 						$groups->query($sql);

	    					$groups->next_record();

	    				}

	    			}

	    		}

	    	}

	    }

		$sql = "SELECT gc.cat_id FROM groups_users gu, groups_categories gc WHERE gu.user_id = '" . CCGetSession("UserID") . "' and gu.group_id = gc.group_id and gc.cat_id='" . $cat . "'";

		$groups = new clsDBNetConnect();

        $groups->connect();

      	$groups->query($sql);

      	if ($groups->next_record()){

      		return 1;

      	}

      	else{

      	    return 0;

      	}

    }

}



function Getfeedbacktotal($user_id){



	$rate = new clsDBNetConnect;

	$query = "select SUM(rating) from feedback where being_rated='" . $user_id . "'";

	$rate->query($query);

	if ($rate->next_record()){

		$return = $rate->f("SUM(rating)");

	}

	else

	    $return = "0";

	if ($return == "")

	    $return = "0";

	return $return;

}



function pricepad($value){

	$pos = strpos($value, ".");

	if (!is_integer($pos)){

		$value .= ".00";

	}

	elseif ($pos == strlen($value) - 2){

	    $value .= "0";

	}

	return $value;

}



function subscribe($user_id, $subsc_id, $paid = 0){

	$db = new clsDBNetConnect;

	$query = "select * from subscription_plans where id = '" . $subsc_id . "'";

	$db->query($query);

	if ($db->next_record()){

		$price = $db->f("price");

		$db2 = new clsDBNetConnect;

		$query = "select * from used_subscriptions where user_id='" . $user_id . "' and subsc_id='" . $subsc_id . "' and expires>'" . time() . "'" ;

		$db2->query($query);

		if ($db2->next_record()){

			addtogroup($user_id, $db->f("group"), $db2->f("group"));

			$expires = $db2->f("expires");

			$duration = $db->f("duration");

			$duration = $duration*86400;

			$duration = $duration+$expires;

			if ($db->f("unlimited"))

				$duration = 9999999999;

			$query = "insert into used_subscriptions (`user_id`, `date`, `expires`, `subsc_id`, `paid`, `group`, `active`) values ('" . $user_id . "', '" . time() . "', '" . $duration . "', '" . $subsc_id . "', '" . $paid . "', '" . $db->f("group") . "', '1')";

			$db2->query($query);

		} else {

			addtogroup($user_id, $db->f("group"));

			$duration = $db->f("duration");

			$duration = $duration*86400;

			if ($db->f("intro") && $db->f("intro_price") == $paid){

				$duration = $db->f("intro_duration");

				$duration = $duration*86400;

			}

			$duration = $duration+time();

			if ($db->f("unlimited"))

				$duration = 9999999999;

			$query = "insert into used_subscriptions (`user_id`, `date`, `expires`, `subsc_id`, `paid`, `group`, `active`) values ('" . $user_id . "', '" . time() . "', '" . $duration . "', '" . $subsc_id . "', '" . $paid . "', '" . $db->f("group") . "', '1')";

			$db->query($query);

		}

		$return = 1;

	}

	else {

		print "Invalid Subscription ID Specified";

		exit;

	}

	return $return;

}



function addtogroup($user_id, $addto, $removefrom=""){

	$db = new clsDBNetConnect;

	$query = "select * from groups where id=" . $addto;

	$db->query($query);

	if ($db->next_record()){

		$db2 = new clsDBNetConnect;

		$query = "delete from groups_users where user_id = '" . $user_id . "' and group_id = '" . $addto . "'";

		$db2->query($query);

		if ($removefrom){

			$query = "delete from groups_users where user_id = '" . $user_id . "' and group_id = '" . $group_id . "'";

			$db2->query($query);

		}

		$query = "insert into groups_users (`user_id`, `group_id`) values ('" . $user_id . "', '" . $addto . "')";

		$db2->query($query);

		if ($db->f("tokens") > 0){

			$tokens = $db->f("tokens");

			$query = "select tokens from users where user_id = $user_id";

			$db->query($query);

			if ($db->next_record()){

				$existingtokens = $db->f("tokens");

				$newtokens = $tokens + $existingtokens;

				$query = "update users set tokens = '" . $newtokens . "' where user_id = '" . $user_id . "'";

				$db->query($query);

			}

		}

	}

}



function endsubscription($active_id){

	$db = new clsDBNetConnect;

	$query = "select * from used_subscriptions where `id` = " . $active_id;

	$db->query($query);

	if ($db->next_record()){

		$group = $db->f("group");

		$user_id = $db->f("user_id");

		$query = "select * from `used_subscriptions` where `subsc_id` = '" . $db->f("subsc_id") . "' and `id` != '" . $active_id . "' and `user_id` = '" . $user_id . "' and `active` = '1'";

		$db->query($query);

		if ($db->next_record()){

			$renewed = 1;

		}

		$query = "update used_subscriptions set `active` = '0', expires = " . time() . " where `id` = " . $active_id;

		$db->query($query);

		if (!$renewed){

			if ($group != 1){

				$query = "delete from groups_users where user_id = " . $user_id . " and group_id = " . $group;

				$db->query($query);

			}

// Uncomment this section if you want to close all of a user's listings when their subscription expires

//			$query = "SELECT * from items where `user_id` = '" . $user_id . "' and `status`='1'";

//       	$db->query($query);

//        	$db2 = new clsDBNetConnect;

//        	while ($db->next_record()){

//				$query = "UPDATE `items` SET `end_reason` = 'Subscription Expired', `status` = '2', `closes` = '" . time() . "' WHERE `ItemNum` = '". $db->f("ItemNum") . "'";

//        		$db2->query($query);

//        		$query = "delete from listing_index where `ItemNum` = '" . $db->f("ItemNum") . "'";

//        		$db2->query($query);

//	        	subtract_catcounts($db->f("category"));

//        	}	

		}

	}

}



function subscription_membership($user_id, $mode="icon", $seperator="&nbsp;", $showexpire = 0){

	$db = new clsDBNetConnect;

	$query = "select * from used_subscriptions where expires>" . time() . " and active=1 and user_id=" . $user_id;

	$db->query($query);

	$subscriptions = "";

	$i = 0;

	while ($db->next_record()){

		if ($i > 0)

			$subscriptions .= " or ";

		$subscriptions .= "id = " . $db->f("subsc_id");

		if ($db->f("expires") == 9999999999)

			$expire[$db->f("subsc_id")] = "Never";

		else

			$expire[$db->f("subsc_id")] = date("F j, Y, g:i a",$db->f("expires"));

		$i++;

	}

	if ($subscriptions){

		$query = "select * from subscription_plans where " . $subscriptions;

		$db->query($query);

		$subscription_memberships = "";

		while ($db->next_record()){

			if ($showexpire){

				if ($mode == "icon"){

					if ($db->f("icon")){

						$subscription_memberships .= "<img src=\"images/" . $db->f("icon") . "\" border=\"0\">&nbsp;--&nbsp;Expires:" . $expire[$db->f("id")] . $seperator;

					}

				}

				if ($mode == "text"){

					$subscription_memberships .= $db->f("title") . "&nbsp;--&nbsp;Expires:" . $expire[$db->f("id")] . $seperator;

				}

				if ($mode == "icontext"){

					if ($db->f("icon")){

						$subscription_memberships .= "<img src=\"images/" . $db->f("icon") . "\" border=\"0\">&nbsp;";

					}

					$subscription_memberships .= $db->f("title") . "&nbsp;--&nbsp;Expires:" . $expire[$db->f("id")] . $seperator;

				}

			}	

			else{

				if ($mode == "icon"){

					if ($db->f("icon")){

						$subscription_memberships .= "<img src=\"images/" . $db->f("icon") . "\" border=\"0\">" . $seperator;

					}

				}

				if ($mode == "text"){

					$subscription_memberships .= $db->f("title") . $seperator;

				}

				if ($mode == "icontext"){

					if ($db->f("icon")){

						$subscription_memberships .= "<img src=\"images/" . $db->f("icon") . "\" border=\"0\">&nbsp;";

					}

					$subscription_memberships .= $db->f("title") . $seperator;

				}

			}

		}

	}

	return $subscription_memberships;

}



function test_admin_group(){

	if (CCGetUserID()){

		$db = new clsDBNetConnect;

		$query = "select `fe_admin` from `groups` g, `groups_users` gu where gu.user_id = '" . CCGetUserID() . "' and gu.group_id = g.id and g.fe_admin = '1'";

		$db->query($query);

		if ($db->next_record())

			return "1";

		else

			return "0";

	}

}



//index Functions

function index_listing($ItemNum, $data="", $type="", $field_id="", $field_num=""){

	$db = new clsDBNetConnect;

	$db3 = new clsDBNetConnect;

	$terms = 0;

	if (!$data && $ItemNum && !$type){

		$query = "delete from listing_index where `ItemNum` = '" .  $ItemNum . "' and `field_type` = 'main'";

		$db->query($query);

		$query = "select * from items where ItemNum = '" . $ItemNum . "'";

		$db->query($query);

		if ($db->next_record()){

			$text = strip_tags(html_entity_decode($db->f("title") . " " . $db->f("description") . " " . $db->f("added_description") . " " . $db->f("city_town") . " " . $db->f("state_province")));

			$text = str_replace("\n", " ", $text);

			$text = str_replace(",", " ", $text);

			$text = preg_replace("/[^A-Z,^a-z,^\',^0-9]/", " ", $text);

			$array = explode(" ", $text);

			$terms = 1;

			while (list($key, $value) = each($array)) {

				if (strlen($value) > 0) {

					$query = "insert into listing_index (`ItemNum`, `value`, `pos`, `field_type`) values ('" . mysql_escape_string($db->f("ItemNum")) . "', '" . mysql_escape_string($value) . "', '" . $terms . "', 'main')";

					$db3->query($query);

					$terms++;

				}

			}

		}

	}

	elseif ($data && $ItemNum && !$type) {

		$query = "delete from listing_index where `ItemNum` = '" .  $ItemNum . "' and `field_type` = '" . $type . "'";

		$db->query($query);

		$text = strip_tags(html_entity_decode($data));

		$text = str_replace("\n", " ", $text);

		$text = str_replace(",", " ", $text);

		$text = preg_replace("/[^A-Z,^a-z,^\',^0-9]/", " ", $text);

		$array = explode(" ", $text);

		$terms = 1;

		while (list($key, $value) = each($array)) {

			if (strlen($value) > 0) {

				$query = "insert into listing_index (`ItemNum`, `value`, `pos`, `field_type`) values ('" . mysql_escape_string($ItemNum) . "', '" . mysql_escape_string($value) . "', '" . $terms . "', '" . $type . "')";

				$db3->query($query);

				$terms++;

			}

		}

	}

	elseif ($data && $ItemNum && $type){

		$query = "SELECT pos FROM `listing_index` where `ItemNum` = $ItemNum order by pos desc limit 1";

		$db->query($query);

		if ($db->next_record()){

			$terms = $db->f("pos");

			$terms++;

			$terms++;

		}

		else

			$terms = 1;

		if ($type == "dd"){

			$query = "select * from custom_dropdown_options where `id` = $field_num";

			$db->query($query);

			if ($db->next_record()) {

				$data = $db->f("option");

			}

		}

		$query = "delete from listing_index where `ItemNum` = '" .  $ItemNum . "' and `field_type` = '" . $type . "'";

		$db->query($query);

		//print "<br>" . $type . " " . $data;

		$text = strip_tags(html_entity_decode($data));

		$text = str_replace("\n", " ", $text);

		$text = str_replace(",", " ", $text);

		$text = preg_replace("/[^A-Z,^a-z,^\',^0-9]/", " ", $text);

		$array = explode(" ", $text);

		while (list($key, $value) = each($array)) {

			if (strlen($value) > 0) {

				$query = "insert into listing_index (`ItemNum`, `value`, `pos`, `field_type`, `field_id`, `field_num`) values ('" . mysql_escape_string($ItemNum) . "', '" . mysql_escape_string($value) . "', '" . $terms . "', '" . $type . "', '" . $field_id . "', '" . $field_num . "')";

				$db3->query($query);

				$terms++;

			}

		}

	}

}



function searchcustom($data, $type, $field_id, $addedwhere=""){

	$db = new clsDBNetConnect;

	if ($type == "dd"){

		if (strstr($data, "-")) {

			$array = explode("-", $data);

			$localwhere = "(";

			$i = 0;

			while ($array[$i]){

				$localwhere .= " `field_num` = '" . mysql_escape_string($array["$i"]) . "'";

				$i++;

				if ($array["$i"])

				$localwhere .= " or";

				else

				$localwhere .= ")";

			}

			$query = "select ItemNum from listing_index where `field_type` = '" . $type . "' and " . $localwhere . " " . $addedwhere;

		}

		else {

			$query = "select ItemNum from listing_index where `field_type` = '" . $type . "' and `field_num` = '" . $data . "' " . $addedwhere;

		}

	}

	if ($type == "ta" || $type == "tb"){

		if (strstr($data, " ")){

			$array = explode("-", $data);

			$localwhere = "(";

			$i = 0;

			while ($array[$i]){

				if (strlen($array[$i]) > 0){

					$localwhere .= " `value` = '" . mysql_escape_string($array["$i"]) . "'";

					$i++;

					if ($array["$i"])

					$localwhere .= " or";

					else

					$localwhere .= ")";

				}

			}

			$query = "select ItemNum from listing_index where `field_type` = '" . $type . "' and " . $localwhere . " " . $addedwhere;

		}

		else {

			$query = "select ItemNum from listing_index where `field_type` = '" . $type . "' and `value` = '" . $data . "' " . $addedwhere;

		}

	}

	$db->query($query);

	while ($db->next_record()){

		if (!$ItemArray || !in_array($db->f("ItemNum"), $ItemArray)){

			$ItemArray[] = $db->f("ItemNum");

		}

	}

	$i=0; 

	$ItemWhere = "";

	while ($ItemArray["$i"]) { 

		$ItemWhere .= " ItemNum = '" . mysql_escape_string($ItemArray["$i"]) . "'"; 

		$i++; 

		if ($ItemArray["$i"]) 

			$ItemWhere .= " or"; 

		else 

			$ItemWhere .= ""; 

	}

	return $ItemWhere;

}



//end index functions



function stopwatch($startpage) {

    

    $endpage = getmicrotime();

    $buildtime = round($endpage - $startpage, 4);

    

    return $buildtime;

}





function add_catcounts($category){

	$db = new clsDBNetConnect();

	$query = "update `categories` set `count` = `count`+1 where `cat_id` = '" . $category . "'";

	$db->query($query);

	$query = "select `sub_cat_id` from categories where `cat_id` = '" . $category . "'";

	$db->query($query);

	if ($db->next_record()){

		$query = "update `categories` set `count` = `count`+1 where `cat_id` = '" . $db->f("sub_cat_id") . "'";

		$db->query($query);

		$query = "select `sub_cat_id` from categories where `cat_id` = '" . $db->f("sub_cat_id") . "'";

		$db->query($query);

		if ($db->next_record()){

			$query = "update `categories` set `count` = `count`+1 where `cat_id` = '" . $db->f("sub_cat_id") . "'";

			$db->query($query);

			$query = "select `sub_cat_id` from categories where `cat_id` = '" . $db->f("sub_cat_id") . "'";

			$db->query($query);

			if ($db->next_record()){

				$query = "update `categories` set `count` = `count`+1 where `cat_id` = '" . $db->f("sub_cat_id") . "'";

				$db->query($query);

				$query = "select `sub_cat_id` from categories where `cat_id` = '" . $db->f("sub_cat_id") . "'";

				$db->query($query);

				if ($db->next_record()){

					$query = "update `categories` set `count` = `count`+1 where `cat_id` = '" . $db->f("sub_cat_id") . "'";

					$db->query($query);

					$query = "select `sub_cat_id` from categories where `cat_id` = '" . $db->f("sub_cat_id") . "'";

					$db->query($query);

					if ($db->next_record()){

						$query = "update `categories` set `count` = `count`+1 where `cat_id` = '" . $db->f("sub_cat_id") . "'";

						$db->query($query);

					}

				}

			}

		}

	}

}



function subtract_catcounts($category){

	$db = new clsDBNetConnect();

	$query = "update `categories` set `count` = `count`-1 where `cat_id` = '" . $category . "'";

	$db->query($query);

	$query = "select `sub_cat_id` from categories where `cat_id` = '" . $category . "'";

	$db->query($query);

	if ($db->next_record()){

		$query = "update `categories` set `count` = `count`-1 where `cat_id` = '" . $db->f("sub_cat_id") . "'";

		$db->query($query);

		$query = "select `sub_cat_id` from categories where `cat_id` = '" . $db->f("sub_cat_id") . "'";

		$db->query($query);

		if ($db->next_record()){

			$query = "update `categories` set `count` = `count`-1 where `cat_id` = '" . $db->f("sub_cat_id") . "'";

			$db->query($query);

			$query = "select `sub_cat_id` from categories where `cat_id` = '" . $db->f("sub_cat_id") . "'";

			$db->query($query);

			if ($db->next_record()){

				$query = "update `categories` set `count` = `count`-1 where `cat_id` = '" . $db->f("sub_cat_id") . "'";

				$db->query($query);

				$query = "select `sub_cat_id` from categories where `cat_id` = '" . $db->f("sub_cat_id") . "'";

				$db->query($query);

				if ($db->next_record()){

					$query = "update `categories` set `count` = `count`-1 where `cat_id` = '" . $db->f("sub_cat_id") . "'";

					$db->query($query);

					$query = "select `sub_cat_id` from categories where `cat_id` = '" . $db->f("sub_cat_id") . "'";

					$db->query($query);

					if ($db->next_record()){

						$query = "update `categories` set `count` = `count`-1 where `cat_id` = '" . $db->f("sub_cat_id") . "'";

						$db->query($query);

					}

				}

			}

		}

	}

}



?>