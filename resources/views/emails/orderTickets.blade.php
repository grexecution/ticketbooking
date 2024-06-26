<style>
    @import url("https://fonts.googleapis.com/css2?family=Rubik:ital,wght@0,400;0,700;1,500&display=swap");
    @import url("https://fonts.googleapis.com/css2?family=Dosis:wght@700&display=swap");
    body {
        margin: 0;
        padding: 0;
        font-family: "Rubik", sans-serif;
        font-weight: 400;
        background: #929EB1;
    }

    h1,
    h2,
    h3,
    h4,
    h5,
    h6 {
        font-family: "Rubik", sans-serif;
        font-weight: 500;
    }

    .wave-container {
        position: relative;
        z-index: -1;
    }
    .wave-container .wave-bottom {
        position: absolute;
        left: 0px;
        top: 0px;
        width: 100%;
    }
    .wave-container .wave-bottom .wave-bottom-box {
        height: 350px;
        width: 100%;
        background: #101010;
    }
    .wave-container .wave-bottom svg path {
        fill: #929EB1;
    }
    .wave-container .wave-middle {
        position: absolute;
        left: 0px;
        top: 0px;
        width: 100%;
    }
    .wave-container .wave-middle .wave-middle-box {
        height: 250px;
        width: 100%;
        background: #E2E6EF;
    }
    .wave-container .wave-middle svg path {
        fill: #E2E6EF;
    }
    .wave-container .wave-top {
        position: absolute;
        left: 0px;
        top: 0px;
        width: 100%;
    }
    .wave-container .wave-top .wave-top-box {
        height: 150px;
        width: 100%;
        background: #fff;
    }
    .wave-container .wave-top svg path {
        fill: #fff;
    }

    .menu {
        position: absolute;
        left: 0;
        top: 0;
        margin-left: 30px;
        margin-top: 30px;
        font-size: 2.4em;
        color: white;
        display: flex;
        flex-direction: row;
        align-items: center;
        border: 2px dotted white;
        padding: 10px 20px;
    }
    .menu span {
        font-size: 2rem;
        margin-left: 5px;
    }
    .menu:hover {
        border: 2px solid white;
    }

    .wrapper {
        display: flex;
        justify-content: center;
        width: 100%;
        z-index: 100;
    }
    .wrapper .ticket {
        display: flex;
        flex-direction: column;
        justify-content: flex-start;
        align-items: center;
        margin-top: 30px;
        margin-bottom: 100px;
        box-sizing: border-box;
    }
    .wrapper .ticket .logo {
        width: 100px;
        height: 100px;
        background: #fff;
        border-radius: 50%;
        z-index: 100;
        -webkit-box-shadow: 0px 3px 5px 3px rgba(0, 0, 0, 0.1);
        -moz-box-shadow: 0px 3px 5px 3px rgba(0, 0, 0, 0.1);
        box-shadow: 0px 3px 5px 3px rgba(0, 0, 0, 0.1);
        display: flex;
        justify-content: center;
        align-items: center
    }
    .wrapper .ticket .ticket-card {
        width: 500px;
        height: 800px;
        border-radius: 10px;
        margin-left: 20px;
        margin-right: 20px;
        margin-top: -50px;
        margin-bottom: 120px;
    }
    .wrapper .ticket .ticket-card .ticket-header {
        height: 150px;
        width: 100%;
        background: #001461;
        border-radius: 10px 10px 0 0;
        z-index: 80;
        display: flex;
        flex-direction: column;
        justify-content: center;
        align-content: center;
        box-sizing: border-box;
    }
    .wrapper .ticket .ticket-card .ticket-header h1 {
        margin-top: 60px;
        margin-bottom: 5px;
        font-size: 1.8em;
        font-weight: 600;
        width: 100%;
        text-align: center;
        color: #fff;
    }
    .wrapper .ticket .ticket-card .ticket-header h4 {
        margin-top: 0px;
        font-size: 1.2em;
        width: 100%;
        text-align: center;
        color: #fff;
    }
    .wrapper .ticket .ticket-card .ticket-qr-section {
        box-sizing: border-box;
        background: white;
        -webkit-box-shadow: 0px 5px 5px 3px rgba(0, 0, 0, 0.2);
        moz-box-shadow: 0px 5px 5px 3px rgba(0, 0, 0, 0.2);
        box-shadow: 0px 5px 5px 3px rgba(0, 0, 0, 0.2);
    }
    .wrapper .ticket .ticket-card .ticket-qr-section .ticket-qr {
        padding: 30px;
        display: flex;
        justify-content: center;
        align-items: center;
    }
    .wrapper .ticket .ticket-card .ticket-qr-section .ticket-qr img {
        width: 250px;
        height: auto;
    }
    .wrapper .ticket .ticket-card .ticket-qr-section:after {
        display: block;
        content: "";
        background: radial-gradient(circle, #929EB1 5px, white 5px);
        background-size: 20px 20px;
        background-position: 0px 0px;
        width: 100%;
        height: 10px;
        z-index: -1;
    }
    .wrapper .ticket .ticket-card .ticket-body-section {
        background: white;
        -webkit-box-shadow: 0px 5px 5px 3px rgba(0, 0, 0, 0.2);
        moz-box-shadow: 0px 5px 5px 3px rgba(0, 0, 0, 0.2);
        box-shadow: 0px 5px 5px 3px rgba(0, 0, 0, 0.2);
        border-radius: 0 0 10px 10px;
        box-sizing: border-box;
        animation-duration: 1s;
        animation-timing-function: ease-in-out;
    }
    .wrapper .ticket .ticket-card .ticket-body-section:before {
        display: block;
        content: "";
        background: radial-gradient(circle, #929EB1 5px, white 5px);
        background-size: 20px 20px;
        background-position: 0px 10px;
        width: 100%;
        height: 10px;
        z-index: -1;
    }
    .wrapper .ticket .ticket-card .ticket-body-section.cut {
        transform: rotate(5deg) translateX(-20px) translateY(-5px);
        margin-top: 60px;
    }
    .wrapper .ticket .ticket-card .ticket-body-section .info-section {
        padding: 30px;
        box-sizing: border-box;
    }
    .wrapper .ticket .ticket-card .ticket-body-section .info-section .info-row {
        margin-bottom: 20px;
    }
    .wrapper .ticket .ticket-card .ticket-body-section .info-section .info-row .info-label {
        color: #a0afc2;
        font-size: 0.8em;
        font-weight: 700;
        padding-bottom: 2px;
    }
    .wrapper .ticket .ticket-card .ticket-body-section .info-section .info-row .info-data {
        color: #2d3138;
        font-size: 1em;
    }
    .wrapper .ticket .ticket-card .ticket-code {
        text-align: center;
        color: #000;
        font-size: 1em;
        font-weight: 500;
    }

    .wrapper .logo-box {
        display: inline-grid;
        grid-template-columns: auto auto auto;
        width: 500px;
        gap: 20px;
        margin: 30px 0px
    }

    .logo-img {
        width: 100%
    }

    .used {
        position: absolute;
        display: none;
        flex-direction: column;
        justify-content: center;
        align-items: center;
        width: 100%;
        z-index: 1000;
        top: 240px;
        transform: rotate(-20deg) translatey(-30px);
        font-family: "Dosis", sans-serif;
        text-transform: uppercase;
        font-weight: bold;
    }
    .used img {
        width: 400px;
    }
    .used .stamp-date {
        position: absolute;
        top: 130px;
        color: white;
        letter-spacing: 1px;
    }
    .used .stamp-label {
        position: absolute;
        top: 160px;
        font-size: 3.8em;
        color: white;
        letter-spacing: 2px;
    }
    .used .stamp-time {
        position: absolute;
        top: 255px;
        color: white;
        letter-spacing: 1px;
    }
</style>


<div class="wave-container">

    <div class="wave-bottom">
        <div class="wave-bottom-box"></div>
        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1440 320"><path fill="#929EB1" fill-opacity="1" d="M0,320L80,314.7C160,309,320,299,480,277.3C640,256,800,224,960,218.7C1120,213,1280,235,1360,245.3L1440,256L1440,0L1360,0C1280,0,1120,0,960,0C800,0,640,0,480,0C320,0,160,0,80,0L0,0Z"></path></svg>

    </div>

    <div class="wave-middle">
        <div class="wave-middle-box"></div>
        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1440 320"><path fill="#929EB1" fill-opacity="1" d="M0,224L80,234.7C160,245,320,267,480,245.3C640,224,800,160,960,154.7C1120,149,1280,203,1360,229.3L1440,256L1440,0L1360,0C1280,0,1120,0,960,0C800,0,640,0,480,0C320,0,160,0,80,0L0,0Z"></path></svg>

    </div>

    <div class="wave-top">
        <div class="wave-top-box"></div>
        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1440 320">
            <path fill="#929EB1" fill-opacity="1" d="M0,256L80,234.7C160,213,320,171,480,154.7C640,139,800,149,960,133.3C1120,117,1280,75,1360,53.3L1440,32L1440,0L1360,0C1280,0,1120,0,960,0C800,0,640,0,480,0C320,0,160,0,80,0L0,0Z"></path>
        </svg>

    </div>
</div>

<div class="wrapper">
    <div class="ticket">
        <div class="logo">
            <img style="width: 80px" src="https://kabarett-am-see.at/wp-content/uploads/elementor/thumbs/KABARETT-AM-SEE_LOGO-PLAIN_WHITE_BACKGROUND-1-q6sf21nxfuvkwlukympf037j6375osq7s54czbna1c.png"/>
        </div>
        @foreach($order->tickets as $ticket)
            <div class="ticket-card">
                <div class="ticket-header">
                    <h1>{{ $order->event->name }}</h1>
                </div>
                <div class="ticket-qr-section">
                    <div class="redeem-stamp">

                    </div>
                    <div class="ticket-qr" style="display: flex; flex-direction: column">
                        <img src="{{ $ticket->qr_url }}"/>
                        <div class="info-row">
                            <div class="info-data">{{ $ticket->name }} | {{ $ticket->row ? "Row: {$ticket->row}," : '' }} {{ $ticket->seat ? "Seat: {$ticket->seat}," : '' }}</div>
                        </div>
                    </div>
                </div>
                <div id="stub" class="ticket-body-section">
                    <div class="info-section">
                        <div class="info-row">
                            <div class="info-label">Name</div>
                            <div class="info-data">{{ $order->first_name }} {{ $order->last_name }}</div>
                        </div>
                        <div class="info-row">
                            <div class="info-label">Venue</div>
                            <div class="info-data">{{ $order->event->venue->name }} - {{ $order->event->venue->address }}, {{ $order->event->venue->zipcode }}, {{ $order->event->venue->city }}, {{ $order->event->venue->country }}</div>
                        </div>
                        <div style="display: flex; gap: 20px">
                            <div class="info-row">
                                <div class="info-label">Entrance:</div>
                                <div class="info-data">{{ \Carbon\Carbon::parse($order->event->doors_open_time)->format('g:i a') }}</div>
                            </div>
                            <div class="info-row">
                                <div class="info-label">Start:</div>
                                <div class="info-data">{{ \Carbon\Carbon::parse($order->event->start_time)->format('g:i a') }}</div>
                            </div>
                        </div>
                        <div class="info-row">
                            <div class="info-label">Ticket price</div>
                            <div class="info-data">{{ \App\Helpers\PriceHelper::fromFloatToStr($ticket->price) }}</div>
                        </div>
                    </div>
                </div>
                <p class="ticket-code">#{{ $ticket->id }}</p>
                <div class="logo-box">
                    <img class="logo-img" src="https://kabarett-am-see.at/wp-content/uploads/elementor/thumbs/KABARETT-AM-SEE_LOGO-PLAIN_WHITE_BACKGROUND-1-q6sf21nxfuvkwlukympf037j6375osq7s54czbna1c.png"/>
                    <img class="logo-img" src="https://kabarett-am-see.at/wp-content/uploads/elementor/thumbs/KABARETT-AM-SEE_LOGO-PLAIN_WHITE_BACKGROUND-1-q6sf21nxfuvkwlukympf037j6375osq7s54czbna1c.png"/>
                    <img class="logo-img" src="https://kabarett-am-see.at/wp-content/uploads/elementor/thumbs/KABARETT-AM-SEE_LOGO-PLAIN_WHITE_BACKGROUND-1-q6sf21nxfuvkwlukympf037j6375osq7s54czbna1c.png"/>
                    <img class="logo-img" src="https://kabarett-am-see.at/wp-content/uploads/elementor/thumbs/KABARETT-AM-SEE_LOGO-PLAIN_WHITE_BACKGROUND-1-q6sf21nxfuvkwlukympf037j6375osq7s54czbna1c.png"/>
                    <img class="logo-img" src="https://kabarett-am-see.at/wp-content/uploads/elementor/thumbs/KABARETT-AM-SEE_LOGO-PLAIN_WHITE_BACKGROUND-1-q6sf21nxfuvkwlukympf037j6375osq7s54czbna1c.png"/>
                    <img class="logo-img" src="https://kabarett-am-see.at/wp-content/uploads/elementor/thumbs/KABARETT-AM-SEE_LOGO-PLAIN_WHITE_BACKGROUND-1-q6sf21nxfuvkwlukympf037j6375osq7s54czbna1c.png"/>
                </div>
            </div>
        @endforeach
    </div>
</div>
