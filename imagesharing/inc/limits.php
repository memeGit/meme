<?
// guest limits
$max_file_size_guest_mb = $config['FileSizeGuest'];
$max_file_size_guest_kb = $config['FileSizeGuest']*1024;
$max_file_size_guest_b = $config['FileSizeGuest']*1024*1024;


// member lmits
$max_file_size_member_mb = $config['FileSizeMember'];
$max_file_size_member_kb = $config['FileSizeMember']*1024;
$max_file_size_member_b = $config['FileSizeMember']*1024*1024;



if(!$auth_id) // guest  
{
$max_file_size_b = $max_file_size_guest_b;
$max_file_size_mb = $max_file_size_guest_mb;
}
else
{  // member
$max_file_size_b = $max_file_size_member_b;
$max_file_size_mb = $max_file_size_member_mb;
}


if(!$auth_id)
{
$bandwidth_max = $config['BandwidthGuest'];
}
else
{
$bandwidth_max = $config['BandwidthMember']; 
}

?>