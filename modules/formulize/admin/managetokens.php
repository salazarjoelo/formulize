<?php
/**
 * Helps create the page for synchronizing these two systems (DBs)
 * User: Vanessa Synesael
 * Date: 2016-01-16
 */


ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// only webmasters can interact with this page!
global $xoopsUser;
if(!$xoopsUser OR !in_array(XOOPS_GROUP_ADMIN, $xoopsUser->getGroups())) {
    return;
}



$tokenHandler = xoops_getmodulehandler('token', 'formulize');

// delete any expired keys, and/or requested keys
$deleteKey = (isset($_POST['deletekey']) AND $_POST['deletekey']) ? $_POST['deletekey'] : "";
$tokenHandler->delete($deleteKey);

$member_handler = xoops_gethandler('member');
$allGroups = $member_handler->getGroups();
$groupList = array();
foreach($allGroups as $group) {
    $groupid = $group->getVar('groupid');
    //dont display registered users group since we will always add the user to that group
    if($groupid != XOOPS_GROUP_USERS){
        $groupList[$groupid] =  array('name'=>$group->getVar('name'), 'groupid'=>$groupid);
    }
}


// create any new keys requested
if(isset($_POST['save'])) {

    $groups = "";

    foreach($groupList as $group) {
        $id = $group['groupid'];
        if(isset($_POST[$id ])){
            
            $groups = $groups ." " .$group['name'];

        }
    }
    $tokenHandler->insert($groups,intval($_POST['expiry']), intval($_POST['tokenlength']), intval($_POST['maxuses']));
}

// gather all keys and send to screen
$allKeys = array();
foreach($tokenHandler->get() as $key) {
    $allKeys[] = array('group'=>$groupList[$key->getVar('groups')],'key'=>$key->getVar('key'),'expiry'=>$key->getVar('expiry'));
}

$adminPage['groups'] = $groupList;
$adminPage['keys'] = $allKeys;
$adminPage['template'] = "db:admin/managetokens.html";

$breadcrumbtrail[1]['url'] = "page=home";
$breadcrumbtrail[1]['text'] = "Home";
$breadcrumbtrail[2]['text'] = "Manage Tokens";

