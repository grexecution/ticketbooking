<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="author" content="ZXing for JS">
    <title>Ticket Scanner</title>
    <link rel="stylesheet" rel="preload" as="style" onload="this.rel='stylesheet';this.onload=null" href="https://fonts.googleapis.com/css?family=Roboto:300,300italic,700,700italic">
    <link rel="stylesheet" rel="preload" as="style" onload="this.rel='stylesheet';this.onload=null" href="https://unpkg.com/normalize.css@8.0.0/normalize.css">
    <link rel="stylesheet" rel="preload" as="style" onload="this.rel='stylesheet';this.onload=null" href="https://unpkg.com/milligram@1.3.0/dist/milligram.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.1/moment.min.js"></script>
    <style>
        .ticket-container {
            background-color: white;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            text-align: center;
        }
        .ticket-container img {
            max-width: 100%;
        }
        .valid-ticket {
            color: green;
        }
        .details {
            margin-top: 15px;
        }
    </style>
</head>

<body>

<main class="wrapper" style="padding-top:2em">

    <section class="container" id="demo-content">
        <h1 class="title">Scan QR Code from Video Camera</h1>

        <p>
            <a class="button-small button-outline" href="{{ route('site.events') }}">HOME 🏡</a>
        </p>

{{--        <p>This example shows how to scan a QR code with ZXing javascript library from the device video camera. If more--}}
{{--            than one video input devices are available (for example front and back camera) the example shows how to read--}}
{{--            them and use a select to change the input device.</p>--}}

        <div>
            <a class="button" id="startButton">Start</a>
            <a class="button" id="resetButton">Reset</a>
        </div>

        <div>
            <video id="video" width="300" height="200" style="border: 1px solid gray"></video>
        </div>

        <div id="sourceSelectPanel" style="display:none">
            <label for="sourceSelect">Change video source:</label>
            <select id="sourceSelect" style="max-width:400px">
            </select>
        </div>

        <div style="display: table">
            <label for="decoding-style"> Decoding Style:</label>
            <select id="decoding-style" size="1">
                <option value="once">Decode once</option>
                <option value="continuously">Decode continuously</option>
            </select>
        </div>

        <label>Result:</label>
        <div id="result">---</div>
    </section>

    <footer class="footer">
        <section class="container">
        </section>
    </footer>

</main>

<script type="text/javascript" src="https://unpkg.com/@zxing/library@latest"></script>
<script type="text/javascript">
    function decodeOnce(codeReader, selectedDeviceId) {
        codeReader.decodeFromInputVideoDevice(selectedDeviceId, 'video').then((result) => {
            // console.log(result.text)
            // Example: 22_9_63
            // 22 - order_id
            // 9 - event_id
            // 63 - ticket_id
            const arr = result.text.split('_');
            fetch(`/api/events/${arr[1]}/check-in/${arr[2]}`)
                .then(response => response.json())
                .then(data => {
                    console.log('json', data)
                    document.getElementById('result').innerHTML = `
                        <div class="ticket-container">
                            <h1 class="mb-4">Success</h1>
                            <div class="valid-ticket">
                                <h2 class="mb-3">Ticket is valid</h2>
                                <div class="details">
                                    <h3>${data.event.name}</h3>
                                    <p>${moment(data.event.start_date).format('DD.MM.YYYY')} - ${moment(data.event.start_time).format('HH:mm')}</p>
                                    <p>${data.data.category}<br>
                                        ${data.data.row ? 'Row: ' + data.data.row + '<br>' : ''}
                                        ${data.data.seat ? 'Seat: ' + data.data.seat + '<br>' : ''}
                                    <p>Checkins: ${data.checkins}/${data.places}</p>
                                </div>
                            </div>
                        </div>
                    `
                }).catch(error => {
                document.getElementById('result').innerHTML = `
                        <div class="ticket-container">
                            <h1 class="mb-4" style="color: red;">Error</h1>
                            <div class="valid-ticket">
                                <h2 class="mb-3" style="color: red;">Ticket is not valid</h2>
                            </div>
                        </div>
                    `
                })

        }).catch((err) => {
            console.error(err)
            document.getElementById('result').textContent = err
        })
    }

    function decodeContinuously(codeReader, selectedDeviceId) {
        codeReader.decodeFromInputVideoDeviceContinuously(selectedDeviceId, 'video', (result, err) => {
            if (result) {
                // properly decoded qr code
                console.log('Found QR code!', result)
                document.getElementById('result').textContent = result.text
            }

            if (err) {
                // As long as this error belongs into one of the following categories
                // the code reader is going to continue as excepted. Any other error
                // will stop the decoding loop.
                //
                // Excepted Exceptions:
                //
                //  - NotFoundException
                //  - ChecksumException
                //  - FormatException

                if (err instanceof ZXing.NotFoundException) {
                    console.log('No QR code found.')
                }

                if (err instanceof ZXing.ChecksumException) {
                    console.log('A code was found, but it\'s read value was not valid.')
                }

                if (err instanceof ZXing.FormatException) {
                    console.log('A code was found, but it was in a invalid format.')
                }
            }
        })
    }

    window.addEventListener('load', function () {
        let selectedDeviceId;
        const codeReader = new ZXing.BrowserQRCodeReader()
        console.log('ZXing code reader initialized')

        codeReader.getVideoInputDevices()
            .then((videoInputDevices) => {
                const sourceSelect = document.getElementById('sourceSelect')
                selectedDeviceId = videoInputDevices[0].deviceId
                if (videoInputDevices.length >= 1) {
                    videoInputDevices.forEach((element) => {
                        const sourceOption = document.createElement('option')
                        sourceOption.text = element.label
                        sourceOption.value = element.deviceId
                        sourceSelect.appendChild(sourceOption)
                    })

                    sourceSelect.onchange = () => {
                        selectedDeviceId = sourceSelect.value;
                    };

                    const sourceSelectPanel = document.getElementById('sourceSelectPanel')
                    sourceSelectPanel.style.display = 'block'
                }

                document.getElementById('startButton').addEventListener('click', () => {

                    const decodingStyle = document.getElementById('decoding-style').value;

                    if (decodingStyle == "once") {
                        decodeOnce(codeReader, selectedDeviceId);
                    } else {
                        decodeContinuously(codeReader, selectedDeviceId);
                    }

                    console.log(`Started decode from camera with id ${selectedDeviceId}`)
                })

                document.getElementById('resetButton').addEventListener('click', () => {
                    codeReader.reset()
                    document.getElementById('result').textContent = '';
                    console.log('Reset.')
                })

            })
            .catch((err) => {
                console.error(err)
            })
    })
</script>

</body>

</html>
