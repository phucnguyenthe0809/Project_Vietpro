<?php
function showError($errors,$nameInput)
{
    if ($errors->has($nameInput))
    {
        echo '<div class="alert alert-danger" role="alert"><strong>';
        echo $errors->first($nameInput);
        echo '</strong></div>';

    }
    
}

//hiển thị danh mục trong select
function GetCategory($danhMuc,$idDanhMucCha,$chuoiPhanCach,$idChon)
{
  foreach($danhMuc as $banGhi)
    {
     if($banGhi['parent']==$idDanhMucCha)
		{
      if($banGhi['id']==$idChon)
      {
        echo '<option selected value="'.$banGhi['id'].'">'.$chuoiPhanCach.$banGhi['name'].'</option>';
      }
      else {
        echo '<option value="'.$banGhi['id'].'">'.$chuoiPhanCach.$banGhi['name'].'</option>';
      }
		 
		  GetCategory($danhMuc,$banGhi['id'],$chuoiPhanCach.'---|',$idChon);
		}
	}

}

//hiển thị danh mục
function showCategory($danhMuc,$idDanhMucCha,$chuoiPhanCach)
{
  foreach($danhMuc as $banGhi)
    {
     if($banGhi['parent']==$idDanhMucCha)
		{
      echo '
      <div class="item-menu"><span>'.$chuoiPhanCach.$banGhi['name'].'</span>
      <div class="category-fix">
        <a class="btn-category btn-primary" href="/admin/category/edit/'.$banGhi['id'].'"><i class="fa fa-edit"></i></a>
        <a onclick="return delCate()" class="btn-category btn-danger" href="/admin/category/del/'.$banGhi['id'].'"><i class="fas fa-times"></i></i></a>

      </div>
    </div>
      ';
		  ShowCategory($danhMuc,$banGhi['id'],$chuoiPhanCach.'---|');
		}
	}

}

function getLevel($danhMuc,$idCha,$demCap)
{
	
 foreach($danhMuc as $banGhi)
 {
   if($idCha==0)
   {
     return $demCap;
   }
   if($banGhi["id"]==$idCha)
   {
       $demCap++;
	   
	   if($banGhi["parent"]==0)
	   {
	     return $demCap;
	   }
	   return Getlevel($danhMuc,$banGhi["parent"],$demCap);
   
   }
 
 }
}
