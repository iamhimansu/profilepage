<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Welcome</title>
    <link rel="stylesheet" href="./css/theme.min.css" />
    <link rel="stylesheet" href="./css/app.min.css" />
    <link rel="stylesheet" href="assets/fonts/bootstrap-icons/bootstrap-icons.css" />

</head>
<style>
    .nn-tl-big-circle {
        position: absolute;
        background-color: rgba(255, 189, 89, 0.35);
        z-index: -1;
        height: 45em;
        width: 46em;
        left: -15em;
        top: -11em;
        border-top-right-radius: 55%;
        border-bottom-right-radius: 60%;
        border-bottom-left-radius: 55%;
    }

    .nn-sm-c-1 {
        position: absolute;
        background-color: rgba(255, 189, 89, 0.38);
        z-index: -1;
        height: 10em;
        width: 10em;
        border-radius: 50%;
        left: 19em;
        top: 23em;
    }

    .nn-btn {
        border: 5px solid #ffbd59;
        color: #1f365c;
        outline: none;
    }

    .nn-btn.nn-btn-round {
        border-radius: 50px 50px;
    }

    .nn-btn:hover,
    .nn-btn:focus {
        background-color: #ffbd59;
        color: #1f365c;
        border-color: transparent;
    }

    .nn-btn:active,
    .nn-btn.active {
        background-color: #daa625;
        border: 5px solid #daa625;
    }

    .highlight-top:before {
        content: "";
        display: inline-block;
        height: 5px;
        width: 108px;
        background-color: #1f365c;
        padding: 0;
        position: absolute;
        margin-left: 0;
        margin: -10px 0;
    }

    .highlight-bottom:before {
        content: "";
        display: inline-block;
        height: 5px;
        width: 108px;
        background-color: #1f365c;
        margin: 50px 0;
        padding: 0;
        position: absolute;
        margin-left: 0;
    }

    .nn-bright-red {
        background: #e94528;
    }

    .nn-cobalt-blue {
        background: #1f365c;
    }

    .circle-250 {
        height: 250px;
        widows: 250px;
        background-color: #ffbd59;
        border-radius: 50%;
    }

    .nn-transparent {
        border: 2px solid #ffbd59;
        background: rgba(255, 255, 255, 0.5);
    }

    .nn-yellow {
        background-color: #ffbd59;
        color: #1f365c;
    }

    .nn-yellow-light {
        background: rgb(255, 207, 134)
    }

    .nn-yellow-dim {
        background: rgba(253, 152, 0, 0.43);
    }

    .black {
        color: #000000;
    }

    .footer-copyright {
        font-size: 10px;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 0.05em;
        background-color: #ffcf86;
        text-transform: uppercase;
        color: #333435;
        padding: 23px 25px;
    }

    .scroll-top {
        position: fixed;
        bottom: 10px;
        right: 25px;
    }
</style>

<body>
    <div class="pt-6">
        <div class="container">
            <div class="row">
                <div class="col-md-6">
                    <div class="card-body">
                        <h1 class="font-weight-bold text-uppercase highlight-top">
                            Profile Page - <br>Your links, your page</h1>
                        <p>
                            Lorem ipsum dolor sit amet, consectetur adipisicing elit. Asperiores hic quam fuga excepturi
                            molestiae nemo accusamus sit nobis at temporibus, fugiat aliquid recusandae eaque tempore,
                            dolore eligendi sequi tempora praesentium obcaecati iure magnam soluta? Aut sit aliquam iure
                            quia autem!
                        </p>
                        <div>
                            <a href="signup" class="btn btn-default btn-lg px-5 nn-btn nn-btn-round text-bold">
                                Create now
                            </a>
                        </div>
                        <div class="nn-tl-big-circle"></div>
                        <div class="nn-sm-c-1"></div>
                    </div>
                </div>
                <div class="col-md-6">
                    Lorem ipsum dolor sit amet consectetur, adipisicing elit. Pariatur quis nemo quibusdam nihil
                    accusantium iure unde quae est! Fugit animi ab placeat minus nam error eius hic quam maiores neque
                    dolorum labore voluptate soluta ipsa magni, voluptatem quia accusamus nobis vero odio tenetur earum
                    reprehenderit! Esse voluptas fugit, veritatis culpa cum dolor ducimus quasi architecto possimus
                    totam corporis quam magnam dolorem exercitationem maiores alias blanditiis nisi assumenda neque.
                    Vitae dolorum aliquid porro ab optio amet voluptatem commodi cupiditate. Vitae saepe dolores magni
                </div>
            </div>
        </div>
    </div>
    <div class="footer-copyright">
        © Notebook Nation 2020
    </div>

    <a class="scroll-top nn-btn icon-btn btn-circle btn-md p-0 py-2" href="#" scroll="" totop="">
        <span class="bi bi-caret-up sz-24"></span>
    </a>
</body>

</html>