<link rel="stylesheet" href="../js/libs/Croppie/croppie.css" />

<div class="demo">
    <img class="my-image" src="../assets/img/avatars/profiles/avatar-1.jpg" />
</div>

<script src="../js/jquery.min.js"></script>
<script src="../js/libs/Croppie/croppie.min.js"></script>
<script src="../js/libs/exif/exif.js"></script>

<script>
    let photo = $('.my-image');
    photo.croppie({
        enableExif: true,
        viewport: {
            width: 200,
            height: 200,
            type: 'circle',
            enableOrientation: true,
        },
        boundary: {
            width: 100 + '%',
            height: 300
        }
    });
</script>