function deleteData(categoryId = null) {
   Swal.fire({
      title: 'Are you sure?',
      text: "This action will permanently delete the data. Do you want to proceed?",
      icon: 'warning',
      showCancelButton: true,
      confirmButtonColor: '#3085d6',
      cancelButtonColor: '#d33',
      confirmButtonText: 'Yes, delete it!'
   }).then((result) => {
      if (result.isConfirmed) {
         if (categoryId) {
            document.getElementById('formDelete_' + categoryId).submit();
         } else {
            document.getElementById('formDelete').submit();
         }
      }
   });
}

function resetPassword(userId = null) {
   Swal.fire({
      title: 'Are you sure?',
      text: "This action will reset the staff member's password. Do you want to continue?",
      icon: 'warning',
      showCancelButton: true,
      confirmButtonColor: '#3085d6',
      cancelButtonColor: '#d33',
      confirmButtonText: 'Yes, reset it!'
   }).then((result) => {
      if (result.isConfirmed) {
         if (userId) {
            document.getElementById('formReset_' + userId).submit();
         } else {
            document.getElementById('formReset').submit();
         }
      }
   });
}



function previewImage(imageId, imgPreviewId) {
   const image = document.getElementById(imageId);
   const imgPreview = document.getElementById(imgPreviewId);

   if (image.files && image.files[0]) {
      const reader = new FileReader();
      
      reader.onload = function(e) {
         imgPreview.src = e.target.result;
         imgPreview.style.width = '100%';
         imgPreview.style.height = '300px';
         imgPreview.style.objectFit = 'cover';
      }
      
      reader.readAsDataURL(image.files[0]);
   } else {
      imgPreview.src = '';
   }
}


