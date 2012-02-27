<?
function ImageCreateFromBMP($filename)
{
 //Ouverture du fichier en mode binaire
   if (! $f1 = fopen($filename,"rb")) return FALSE;

 //1 : Chargement des ent?tes FICHIER
   $FILE = unpack("vfile_type/Vfile_size/Vreserved/Vbitmap_offset", fread($f1,14));
   if ($FILE['file_type'] != 19778) return FALSE;

 //2 : Chargement des ent?tes BMP
   $BMP = unpack('Vheader_size/Vwidth/Vheight/vplanes/vbits_per_pixel'.
                 '/Vcompression/Vsize_bitmap/Vhoriz_resolution'.
                 '/Vvert_resolution/Vcolors_used/Vcolors_important', fread($f1,40));
   $BMP['colors'] = pow(2,$BMP['bits_per_pixel']);
   if ($BMP['size_bitmap'] == 0) $BMP['size_bitmap'] = $FILE['file_size'] - $FILE['bitmap_offset'];
   $BMP['bytes_per_pixel'] = $BMP['bits_per_pixel']/8;
   $BMP['bytes_per_pixel2'] = ceil($BMP['bytes_per_pixel']);
   $BMP['decal'] = ($BMP['width']*$BMP['bytes_per_pixel']/4);
   $BMP['decal'] -= floor($BMP['width']*$BMP['bytes_per_pixel']/4);
   $BMP['decal'] = 4-(4*$BMP['decal']);
   if ($BMP['decal'] == 4) $BMP['decal'] = 0;

 //3 : Chargement des couleurs de la palette
   $PALETTE = array();
   if ($BMP['colors'] < 16777216)
   {
    $PALETTE = unpack('V'.$BMP['colors'], fread($f1,$BMP['colors']*4));
   }

 //4 : Cr?ation de l'image
   $IMG = fread($f1,$BMP['size_bitmap']);
   $VIDE = chr(0);

   $res = imagecreatetruecolor($BMP['width'],$BMP['height']);
   $P = 0;
   $Y = $BMP['height']-1;
   while ($Y >= 0)
   {
    $X=0;
    while ($X < $BMP['width'])
    {
     if ($BMP['bits_per_pixel'] == 24)
        $COLOR = unpack("V",substr($IMG,$P,3).$VIDE);
     elseif ($BMP['bits_per_pixel'] == 16)
     { 
        $COLOR = unpack("n",substr($IMG,$P,2));
        $COLOR[1] = $PALETTE[$COLOR[1]+1];
     }
     elseif ($BMP['bits_per_pixel'] == 8)
     { 
        $COLOR = unpack("n",$VIDE.substr($IMG,$P,1));
        $COLOR[1] = $PALETTE[$COLOR[1]+1];
     }
     elseif ($BMP['bits_per_pixel'] == 4)
     {
        $COLOR = unpack("n",$VIDE.substr($IMG,floor($P),1));
        if (($P*2)%2 == 0) $COLOR[1] = ($COLOR[1] >> 4) ; else $COLOR[1] = ($COLOR[1] & 0x0F);
        $COLOR[1] = $PALETTE[$COLOR[1]+1];
     }
     elseif ($BMP['bits_per_pixel'] == 1)
     {
        $COLOR = unpack("n",$VIDE.substr($IMG,floor($P),1));
        if     (($P*8)%8 == 0) $COLOR[1] =  $COLOR[1]        >>7;
        elseif (($P*8)%8 == 1) $COLOR[1] = ($COLOR[1] & 0x40)>>6;
        elseif (($P*8)%8 == 2) $COLOR[1] = ($COLOR[1] & 0x20)>>5;
        elseif (($P*8)%8 == 3) $COLOR[1] = ($COLOR[1] & 0x10)>>4;
        elseif (($P*8)%8 == 4) $COLOR[1] = ($COLOR[1] & 0x8)>>3;
        elseif (($P*8)%8 == 5) $COLOR[1] = ($COLOR[1] & 0x4)>>2;
        elseif (($P*8)%8 == 6) $COLOR[1] = ($COLOR[1] & 0x2)>>1;
        elseif (($P*8)%8 == 7) $COLOR[1] = ($COLOR[1] & 0x1);
        $COLOR[1] = $PALETTE[$COLOR[1]+1];
     }
     else
        return FALSE;
     imagesetpixel($res,$X,$Y,$COLOR[1]);
     $X++;
     $P += $BMP['bytes_per_pixel'];
    }
    $Y--;
    $P+=$BMP['decal'];
   }

 //Fermeture du fichier
   fclose($f1);

 return $res;
}



function imagebmp($img,$file="",$RLE=0)
{


$ColorCount=imagecolorstotal($img);

$Transparent=imagecolortransparent($img);
$IsTransparent=$Transparent!=-1;


if($IsTransparent) $ColorCount--;

if($ColorCount==0) {$ColorCount=0; $BitCount=24;};
if(($ColorCount>0)and($ColorCount<=2)) {$ColorCount=2; $BitCount=1;};
if(($ColorCount>2)and($ColorCount<=16)) { $ColorCount=16; $BitCount=4;};
if(($ColorCount>16)and($ColorCount<=256)) { $ColorCount=0; $BitCount=8;};


                $Width=imagesx($img);
                $Height=imagesy($img);

                $Zbytek=(4-($Width/(8/$BitCount))%4)%4;

                if($BitCount<24) $palsize=pow(2,$BitCount)*4;

                $size=(floor($Width/(8/$BitCount))+$Zbytek)*$Height+54;
                $size+=$palsize;
                $offset=54+$palsize;

                // Bitmap File Header
                $ret = 'BM';                        // header (2b)
                $ret .= int_to_dword($size);        // size of file (4b)
                $ret .= int_to_dword(0);        // reserved (4b)
                $ret .= int_to_dword($offset);        // byte location in the file which is first byte of IMAGE (4b)
                // Bitmap Info Header
                $ret .= int_to_dword(40);        // Size of BITMAPINFOHEADER (4b)
                $ret .= int_to_dword($Width);        // width of bitmap (4b)
                $ret .= int_to_dword($Height);        // height of bitmap (4b)
                $ret .= int_to_word(1);        // biPlanes = 1 (2b)
                $ret .= int_to_word($BitCount);        // biBitCount = {1 (mono) or 4 (16 clr ) or 8 (256 clr) or 24 (16 Mil)} (2b)
                $ret .= int_to_dword($RLE);        // RLE COMPRESSION (4b)
                $ret .= int_to_dword(0);        // width x height (4b)
                $ret .= int_to_dword(0);        // biXPelsPerMeter (4b)
                $ret .= int_to_dword(0);        // biYPelsPerMeter (4b)
                $ret .= int_to_dword(0);        // Number of palettes used (4b)
                $ret .= int_to_dword(0);        // Number of important colour (4b)
                // image data

                $CC=$ColorCount;
                $sl1=strlen($ret);
                if($CC==0) $CC=256;
                if($BitCount<24)
                   {
                    $ColorTotal=imagecolorstotal($img);
                     if($IsTransparent) $ColorTotal--;

                     for($p=0;$p<$ColorTotal;$p++)
                     {
                      $color=imagecolorsforindex($img,$p);
                       $ret.=inttobyte($color["blue"]);
                       $ret.=inttobyte($color["green"]);
                       $ret.=inttobyte($color["red"]);
                       $ret.=inttobyte(0); //RESERVED
                     };

                    $CT=$ColorTotal;
                  for($p=$ColorTotal;$p<$CC;$p++)
                       {
                      $ret.=inttobyte(0);
                      $ret.=inttobyte(0);
                      $ret.=inttobyte(0);
                      $ret.=inttobyte(0); //RESERVED
                     };
                   };


if($BitCount<=8)
{

 for($y=$Height-1;$y>=0;$y--)
 {
  $bWrite="";
  for($x=0;$x<$Width;$x++)
   {
   $color=imagecolorat($img,$x,$y);
   $bWrite.=decbinx($color,$BitCount);
   if(strlen($bWrite)==8)
    {
     $retd.=inttobyte(bindec($bWrite));
     $bWrite="";
    };
   };

  if((strlen($bWrite)<8)and(strlen($bWrite)!=0))
    {
     $sl=strlen($bWrite);
     for($t=0;$t<8-$sl;$t++)
      $sl.="0";
     $retd.=inttobyte(bindec($bWrite));
    };
 for($z=0;$z<$Zbytek;$z++)
   $retd.=inttobyte(0);
 };
};

if(($RLE==1)and($BitCount==8))
{
 for($t=0;$t<strlen($retd);$t+=4)
  {
   if($t!=0)
   if(($t)%$Width==0)
    $ret.=chr(0).chr(0);

   if(($t+5)%$Width==0)
   {
     $ret.=chr(0).chr(5).substr($retd,$t,5).chr(0);
     $t+=1;
   }
   if(($t+6)%$Width==0)
    {
     $ret.=chr(0).chr(6).substr($retd,$t,6);
     $t+=2;
    }
    else
    {
     $ret.=chr(0).chr(4).substr($retd,$t,4);
    };
  };
  $ret.=chr(0).chr(1);
}
else
{
$ret.=$retd;
};


                if($BitCount==24)
                {
                for($z=0;$z<$Zbytek;$z++)
                 $Dopl.=chr(0);

                for($y=$Height-1;$y>=0;$y--)
                 {
                 for($x=0;$x<$Width;$x++)
                        {
                           $color=imagecolorsforindex($img,ImageColorAt($img,$x,$y));
                           $ret.=chr($color["blue"]).chr($color["green"]).chr($color["red"]);
                        }
                 $ret.=$Dopl;
                 };

                 };

  if($file!="")
   {
    $r=($f=fopen($file,"w"));
    $r=$r and fwrite($f,$ret);
    $r=$r and fclose($f);
    return $r;
   }
  else
  {
   echo $ret;
  };
};
?>