<?php

//Require controllers
require_once 'controllers/database.php';
require_once 'controllers/modules/Encryption.php';
require_once 'controllers/modules/core.php';
require_once 'controllers/functions.php';

$User = new User();
$fetch = new CodeFlirt\Fetch();
$handle = new CodeFlirt\Handlers();

session_name("PP");
session_start();

//Check if user is logged in
//else force login
$User->isAuthenticated();
//
//PAGE_ID imported from Route
$Page = new Page();
$Page->Find($PAGE_ID);
$PageDetails = $Page->Details();

if ($PageDetails) {
    $page_name = $PageDetails["PageName"];
    $user_name = $PageDetails["OwnerName"];

    $_SESSION["PageID"] = $PageDetails["PageRefId"];
} else {
    echo '<title>Not found</title>';
    die("Page does not exists.");
}
//
//GET PAGE POHOT
if ($Page->photo()) {
    $page_photo = $handle->path($Page->photo());
} else {
    $page_photo = $handle->path($User->photos($User->Details($PageDetails["OwnerRefId"])));
}
$CurrentPage = "pages";
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo "$page_name"; ?> | ProfilePage</title>
    <link rel="stylesheet" id="theme" href="<?php echo $handle->path('css/theme.min.css') ?>" class="" />
    <link rel="stylesheet" href="<?php echo $handle->path('css/app.min.css') ?>" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css" />
    <link rel="stylesheet" href="<?php echo $handle->path('assets/fonts/bootstrap-icons/bootstrap-icons.css') ?>" />
    <link rel="stylesheet" href="<?php echo $handle->path('js/snackbar/snackbar.css') ?>" />
    <link rel="stylesheet" href="<?php echo $handle->path('js/libs/Croppie/croppie.css') ?>" />

</head>
<style>
    .color {
        border: 2px solid transparent;
        border-radius: 50%;
        transition: 0.2s ease-in-out;
        margin: 5px;
        height: 45px;
        width: 45px;
        cursor: pointer;
    }

    .color>.color-fill {
        display: block;
        width: 100%;
        height: 100%;
        border-radius: 50%;
    }

    .color:hover {
        border: 2px solid #95aac9;
    }

    .color.active {
        border: 2px solid #95aac9;
        padding: 4px !important;
    }

    #preview-page-customisation,
    #preview-page-customisation>.wrapper>.ppage {
        -webkit-transition: 0.2s linear;
        -moz-transition: 0.2s linear;
        -o-transition: 0.2s linear;
        transition: 0.2s linear;
        min-height: 100vh;
    }

    input[type="color"] {
        opacity: 0;
        display: block;
        width: 100%;
        height: 100%;
        border: none;
        cursor: pointer;
        border-radius: 50%;
    }

    #color-picker-wrapper,
    #font-color-picker-wrapper {
        width: 45px;
        height: 45px;
        border-radius: 50%;
        border: 4px solid #95aac9;
    }
</style>

<body>
    <?php
    // include navbar
    include 'template/template.side-navbar.php';
    include 'template/template.bottom-navbar.php';

    ?>
    <div class="main-content">
        <div class="row justify-content-center no-gutters">
            <div class="col-md-4">
                <div class="position-relative">
                    <div class="card rounded-0 border-0">
                        <div class="list-group list-group-flush px-3 rounded-0">
                            <div class="list-group-item h-auto">
                                <div class="d-flex justify-content-between align-items-center h-auto">
                                    <!-- Title -->
                                    <h4 class="mb-0">
                                        / <a href="<?php echo $handle->path("@$user_name/$page_name"); ?>""><?php echo $page_name; ?></a>
                                    </h4>
                                    <!-- Caption -->
                                    <div class=" btn-group">
                                            <button class="btn btn-white btn-sm" id="reload-preview">
                                                <i class="bi bi-arrow-repeat"></i> Reload
                                            </button>
                                            <button class="btn btn-white btn-sm" id="update-configs">
                                                <i class="bi bi-check"></i> Publish
                                            </button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="accordion custom-scroll" id="pageCustomisation">
                        <div class="list-group-item p-2">
                            <h2 class="mb-0 position-relative">
                                <button class="btn btn-link stretched-link" type="button" data-toggle="collapse" data-target="#backgroundColorPanel" aria-expanded="true" aria-controls="collapseOne">
                                    Background color
                                </button>
                            </h2>
                            <div id="backgroundColorPanel" class="collapse" aria-labelledby="backgroundColorPanel">
                                <div class="btn-group">
                                    <button class="btn btn-white btn-sm" id="lightColorPallete">
                                        <i class="bi bi-circle-half"></i> Light
                                    </button>
                                    <button class="btn btn-white btn-sm" id="darkColorPallete">
                                        <i class="bi bi-circle-fill"></i> Dark
                                    </button>
                                    <button class="btn btn-white btn-sm position-relative" id="newColorPallete">
                                        <input type="color" class="position-absolute" id="pageBGColorPicker">
                                        Choose
                                    </button>
                                </div>

                                <div class="p-2">
                                    <div id="color-pallete" class="d-flex flex-wrap justify-content-center"></div>
                                    <div class="input-group mb-3">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text py-0">
                                                <button class="btn btn-sm" id="clipboard-data"><i class="bi bi-clipboard"></i></button></span>
                                        </div>
                                        <input type="text" class="form-control" placeholder="Enter hex color code" id="customColor">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="list-group-item p-2">
                            <h2 class="mb-0 position-relative">
                                <button class="btn btn-link collapsed stretched-link" type="button" data-toggle="collapse" data-target="#pageForeColor" data-parent="#pageCustomisation" aria-expanded="false" aria-controls="pageForeColor">
                                    Foreground color
                                </button>
                            </h2>
                            <div id="pageForeColor" class="collapse" aria-labelledby="pageForeColor">
                                <div class="p-2 d-flex justify-content-center">
                                    <div id="color-picker-wrapper">
                                        <input type="color" value="#ffffff" class="form-control rounded-pill p-2" id="foreColor">
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="list-group-item p-2">
                            <h2 class="mb-0 position-relative">
                                <button class="btn btn-link collapsed stretched-link" type="button" data-toggle="collapse" data-target="#pageFontColor" data-parent="#pageCustomisation" aria-expanded="false" aria-controls="pageFontColor">
                                    Font color
                                </button>
                            </h2>
                            <div id="pageFontColor" class="collapse" aria-labelledby="pageFontColor">
                                <div class="p-2 d-flex justify-content-center">
                                    <div id="font-color-picker-wrapper">
                                        <input type="color" value="#000000" class="form-control rounded-pill p-2" id="fontColor">
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="list-group-item p-2">
                            <h2 class="mb-0 position-relative">
                                <button class="btn btn-link collapsed stretched-link U-PI" type="button" data-toggle="collapse" data-target="#pageImage" data-parent="#pageCustomisation" aria-expanded="false" aria-controls="pageImage">
                                    Page Image
                                </button>
                            </h2>
                            <div id="pageImage" class="collapse">
                                <div class="card-body">
                                    <div id="page-image-container">
                                        <div class="ppage-image">
                                        </div>
                                        <button class="btn btn-white btn-sm d-none" id="updatePageImage">Update</button>
                                        <button class="btn btn-primary btn-sm btn-block" id="uploadPageImage">Add</button>
                                        <input type="file" id="uploadPageImageData" hidden />
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="list-group-item p-2">
                            <h2 class="mb-0 position-relative">
                                <button class="btn btn-link collapsed stretched-link U-PI" type="button" data-toggle="collapse" data-target="#pageBGImage" data-parent="#pageCustomisation" aria-expanded="false" aria-controls="pageBGImage">
                                    Page Background image
                                </button>
                            </h2>
                            <div id="pageBGImage" class="collapse" aria-labelledby="pageBgImage">
                                <div class="card-body">
                                    <div id="page-bg-image-container">
                                        <div class="ppage-bg-image">
                                        </div>
                                        <!-- Switch -->
                                        <div class="custom-control custom-switch mb-3 text-center">
                                            <input type="checkbox" class="custom-control-input" id="fixed-page-background" checked>
                                            <label class="custom-control-label" for="fixed-page-background">Fixed background</label>
                                        </div>
                                        <button class="btn btn-white btn-sm d-none" id="updatePageBGImage">Update</button>
                                        <button class="btn btn-primary btn-sm btn-block" id="uploadPageBGImage">Add</button>
                                        <input type="file" id="uploadPageBGImageData" hidden />
                                    </div>
                                </div>
                                <div class="card bg-light border">
                                    <div class="card-body">
                                        <div class="card-text">
                                            Create a nice transparent glass effect using transparency level.</div>
                                    </div>
                                </div>
                                <label for="transparency" class="form-label">Transparency level</label>
                                <input type="range" min="10" max="100" step="5" class="form-range d-block w-100" id="transparency">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-8 border-left">
            <div class="custom-scroll" id="preview-page-customisation">
                <div class="h-100">
                    <div class="d-flex h-100 justify-content-center align-items-center flex-column">
                        <div class="spinner-border my-3" role="status">
                            <span class="sr-only">Loading...</span>
                        </div>
                        <div>
                            Loading page
                        </div>
                    </div>
                </div>
            </div>
            <style id="override">
            </style>
        </div>
    </div>
    </div>

    <script src="<?php echo $handle->path('js/jquery.min.js') ?>"></script>
    <script src="<?php echo $handle->path('js/bootstrap.bundle.min.js') ?>"></script>
    <script src="<?php echo $handle->path('js/axios/axios.min.js') ?>"></script>
    <script src="<?php echo $handle->path('js/libs/Croppie/croppie.min.js') ?>"></script>
    <script src="<?php echo $handle->path('js/libs/exif/exif.js') ?>"></script>
    <script src="<?php echo $handle->path('js/snackbar/snackbar.min.js') ?>"></script>
    <script src="<?php echo $handle->path('js/app.min.js') ?>"></script>

    <script>
        function addNewStyle(newStyle) {
            var styleElement = document.getElementById('override');
            if (!styleElement) {
                styleElement = document.createElement('style');
                styleElement.setAttribute("type", "text/css");
                styleElement.setAttribute("id", "override");
                document.getElementsByTagName('head')[0].appendChild(styleElement);
            }
            styleElement.appendChild(document.createTextNode(newStyle));
        }

        var pageConfigs = new FormData();
        let saturation = (25 + 70 * Math.random()) + '%',
            lumensity = (85 + 10 * Math.random()) + '%';

        function update_style() {
            let css = "";

            for (var selectors in customized) {
                css += selectors + JSON.stringify(customized[selectors]).split(",").join(";");
            }
            console.log(css);
            $("#override").html(css);
        }

        function colorPallete() {
            function getColor() {
                return "hsl(" + 360 * Math.random() + ',' + saturation + ',' + lumensity + ")";
            }
            /*Generate 20 colors*/
            $("#color-pallete").append("<div class='color active' data-color='rgb(249, 251, 253)'><span class='color-fill' style='background:rgb(249, 251, 253)'></span></div>");

            for (var i = 20; i--;) {
                var colorContainer = document.createElement("div");
                var colorFill = document.createElement("span");
                colorFill.classList.add("color-fill");
                colorContainer.append(colorFill);
                colorContainer.classList.add("color");
                colorFill.style.cssText = 'background: ' + getColor() + ';';
                colorContainer.setAttribute("data-color", colorFill.style.background);
                $("#color-pallete").append(colorContainer);
            }

            $(".color").on("click", function() {
                $(".color").removeClass("active");
                $(this).addClass("active");
                var propertyValue = String($(this).data("color").split('(')[1].split(')')[0].trim());
                var rgb = propertyValue.split(',');
                var hex = rgbToHex(parseInt(rgb[0]), parseInt(rgb[1]), parseInt(rgb[2]));
                addNewStyle('#preview-page-customisation > .wrapper > .ppage {background-color: ' + $(this).data("color") + ' !important;}');
                pageConfigs.append("page_bg_color", $(this).data("color"));
            });
        }

        function componentToHex(c) {
            var hex = c.toString(16);
            return hex.length == 1 ? "0" + hex : hex;
        }

        function rgbToHex(r, g, b) {
            return "#" + componentToHex(r) + componentToHex(g) + componentToHex(b) + "";
        }
        colorPallete();
        $("#lightColorPallete").on('click', function() {
            saturation = (25 + 70 * Math.random()) + '%', lumensity = (85 + 10 * Math.random()) + '%';
            $("#color-pallete").html('');
            return colorPallete();
        });
        $("#darkColorPallete").on('click', function() {
            saturation = (90 + 10 * Math.random()) + '%', lumensity = (35 + 10 * Math.random()) + '%';
            $("#color-pallete").html('');
            return colorPallete();
        });

        function load_preview() {
            $("#preview-page-customisation").load(
                '<?php echo $handle->path($PAGE_ID); ?>?c="' + Math.ceil(Math.random() * (1000000000 - 1) + 1) + ' .wrapper',
                function(resp) {
                    if (resp) {
                        $("#preview-page-customisation").html(resp.responseText);
                        /* console.log(resp);*/
                    }

                });
        }
        $("#newColorPallete").on("click", function() {
            $("#color-pallete").html('');
            colorPallete();
        });
        $("#pageBGColorPicker").on("input", function() {
            addNewStyle('#preview-page-customisation > .wrapper > .ppage {background-color: ' + $(this).val() + ' !important;}');
            pageConfigs.append("page_bg_color", $(this).val());
        });
        load_preview();
        $("#reload-preview").on("click", function() {
            $("#preview-page-customisation > .wrapper > .ppage").html(`<div class="vh-100">
                        <div class="d-flex h-100 justify-content-center align-items-center flex-column">
                            <div class="spinner-border my-3" role="status">
                                <span class="sr-only">Loading...</span>
                            </div>
                            <div>
                                Loading page
                            </div>
                        </div>
                    </div>`),
                load_preview()
        });
        $("#clipboard-data").on("click", function() {
            navigator.clipboard.readText()
                .then(function(text) {
                    $("#customColor").focus(),
                        $('#customColor').val(text),
                        updateBackground();
                });
        });

        function updateBackground() {
            let customColor = $("#customColor").val();
            if (customColor.indexOf("#") !== -1) {
                customColor = customColor.split("#")[1];
            }
            let customColorLength = customColor.length;
            let hexCode;
            if (customColorLength > 6 | customColorLength < 3) {
                return;
            } else {
                hexCode = String(customColor);
                addNewStyle('#preview-page-customisation > .wrapper > .ppage {background-color: #' + hexCode + ' !important;}');
                pageConfigs.append("page_bg_color", hexCode);
            }
        }
        $("#customColor").on("keyup", function(e) {
            updateBackground();
        });
        $(function() {

            var pageImage = $('.ppage-image').croppie({
                url: '<?php echo $page_photo; ?>',
                enforceBoundary: true,
                boundary: {
                    width: 100 + "%",
                    height: 250
                },
                viewport: {
                    width: 200,
                    height: 200,
                    type: "circle"
                },
                enableOrientation: true,
                enableExif: true,
                update: function() {
                    $("#updatePageImage").click();
                }
            });

            $("#updatePageImage").on("click", function(ev) {
                pageImage.croppie("result", {
                    type: "base64",
                    size: "viewport",
                    circle: false,
                }).then(function(base64) {
                    $(".page-image").attr("src", base64);
                    pageConfigs.append("page_image", base64);
                })
            });
            $("#uploadPageImage").on("click", function() {
                $("#uploadPageImageData").click();
            });
            $("#uploadPageImageData").on("change", function() {
                $(".ppage-image").append('<div class="image-is-loading d-flex align-items-center justify-content-center position-absolute" style="top:calc(100% - 18em);z-index:10;width:100%"><div style="position:absolute;left:48%;width:10em"><div style="position:relative;left:-50%"><div class="progress" id="image-is-loading"><div class="indeterminate"></div></div></div></div></div>');
                UploadPagePhoto(this, pageImage);
            });

            function UploadPagePhoto(input, element) {
                function readFile() {
                    if (input.files && input.files[0]) {
                        var reader = new FileReader();
                        reader.onload = function(e) {
                            element.croppie("bind", {
                                url: e.target.result
                            }).then(function(e) {
                                $(".image-is-loading").remove();
                            });
                        };
                        reader.readAsDataURL(input.files[0]);
                    } else {
                        alert("Sorry - you're browser doesn't support the FileReader API");
                        input.value = "";
                    }
                }
                readFile();
            }
            var pageBGImage = $('.ppage-bg-image').croppie({
                url: '<?php echo $handle->path($User->photos($User->Details($User->AuthID()))) ?>',
                enforceBoundary: true,
                enableResize: true,
                boundary: {
                    width: 100 + "%",
                    height: 250
                },
                viewport: {
                    width: 300,
                    height: 200,
                    type: "square"
                },
                enableExif: true,
                update: function() {
                    $("#updatePageBGImage").click();
                }
            });
            $("#uploadPageBGImage").on("click", function() {
                $("#uploadPageBGImageData").click();
            });
            $("#uploadPageBGImageData").on("change", function() {
                $(".ppage-bg-image").append('<div class="image-is-loading d-flex align-items-center justify-content-center position-absolute" style="top:calc(100% - 18em);z-index:10;width:100%"><div style="position:absolute;left:48%;width:10em"><div style="position:relative;left:-50%"><div class="progress" id="image-is-loading"><div class="indeterminate"></div></div></div></div></div>');
                UploadPagePhoto(this, pageBGImage);
            });
            $("#updatePageBGImage").on("click", function(ev) {
                pageBGImage.croppie("result", {
                    type: "base64",
                    size: "viewport",
                    circle: false,
                }).then(function(base64) {
                    addNewStyle("#preview-page-customisation > .wrapper > .ppage {background-image: url('" + base64 + "') !important;background-size: cover;background-repeat: no-repeat;background-position: center;background-attachment: fixed;}");
                    pageConfigs.append("page_bg_image", base64);
                })
            });
            $(".U-PI").on("click", function() {
                pageImage.croppie("bind"),
                    pageBGImage.croppie("bind")
            });
            $("#fixed-page-background").on("click", function() {
                if (this.checked) {
                    addNewStyle("#preview-page-customisation > .wrapper > .ppage {background-attachment: fixed;}");
                    pageConfigs.append("background_attachment", "fixed");
                } else {
                    addNewStyle("#preview-page-customisation > .wrapper > .ppage {background-attachment: inherit;}");
                }
            });
            $("#transparency").on("change", function(e) {
                var oldBGColor = $(".ppage-card").css("background-color");
                var newOpacity = changeOpacity(e.target.value, oldBGColor);
                addNewStyle(".ppage-card {background-color:" + newOpacity + " !important;}");
                addNewStyle(".ppage-card .ppage-input {background-color:" + newOpacity + " !important;}");
                pageConfigs.append("page_transparency_level", newOpacity);

            });

            function hexToRgb(hex) {
                var result = /^#?([a-f\d]{2})([a-f\d]{2})([a-f\d]{2})$/i.exec(hex);
                return result ? {
                    r: parseInt(result[1], 16),
                    g: parseInt(result[2], 16),
                    b: parseInt(result[3], 16)
                } : null;
            }
            $("#foreColor").on("input change", function() {
                // var hexColor = hexToRgb($(this).val());
                // var rgba = "rgba(" + hexColor.r + ", " + hexColor.g + ", " + hexColor.b + ", 1)";
                addNewStyle(".ppage-card {background-color:" + $(this).val() + " !important;}");
                $("#color-picker-wrapper").css("background-color", $(this).val());
                pageConfigs.append("page_fore_color", $(this).val());
            });
            $("#color-picker-wrapper").css("background-color", $("#foreColor").val());
            $("#fontColor").on("input change", function() {
                addNewStyle("#preview-page-customisation > .wrapper > .ppage {color: " + $(this).val() + "}");
                $("#font-color-picker-wrapper").css("background-color", $(this).val());
                pageConfigs.append("page_font_color", $(this).val());
            });
            $("#font-color-picker-wrapper").css("background-color", $("#fontColor").val());

            $("#update-configs").on("click", function() {
                UpdateConfigs();
            });

            function changeOpacity(opactiyLevel, oldBGColor) {
                var alpha = opactiyLevel / 100;

                var newBGColor;

                if (oldBGColor.split("(")[0].length === 3) {
                    newBGColor = oldBGColor.replace('rgb', 'rgba').replace(')', ', ' + alpha + ')');
                }
                // var oldBGColor = $('#div').css('backgroundColor');
                // rgb(40,40,40)
                else {
                    newBGColor = oldBGColor.split(",");
                    newBGColor[3] = " " + alpha + ")";
                    newBGColor = newBGColor.join();
                }
                // console.log(newBGColor.split(","));
                // rgba(40,40,40,.8)

                return newBGColor;
            }

            function UpdateConfigs() {
                axios({
                    url: "../../controllers/Handlers/page.customization.Handler.php",
                    method: "post",
                    data: pageConfigs
                }).then(function(response) {
                    if (response.data.length === 0) {
                        Snackbar.show({
                            pos: "top-center",
                            text: "Page updated. 😊",
                        });
                        $("#reload-preview").click();
                    }
                });
            };
        });
        $(function() {
            $('.ppage-image').croppie("bind"),
                $('.ppage-bg-image').croppie("bind");
        });
    </script>
</body>

</html>