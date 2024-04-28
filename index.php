<!DOCTYPE html>
<html>
<head>
  <title>QR Code Scanner</title>
  <script src="https://rawgit.com/schmich/instascan-builds/master/instascan.min.js"></script>
  <style>
    body {
      font-family: Arial, sans-serif;
      background-color: #f4f4f4;
      margin: 0;
      padding: 0;
      display: flex;
      flex-direction: column;
      align-items: center;
      justify-content: center;
      height: 100vh;
    }

    #scannerContainer {
      position: relative;
      background-color: #fff;
      padding: 20px;
      border-radius: 10px;
      box-shadow: 0 0 20px rgba(0, 0, 0, 0.1);
      margin-bottom: 20px;
    }

    #preview {
      width: 100%;
    }

    button {
      background-color: #007bff;
      color: #fff;
      border: none;
      padding: 10px 20px;
      margin-top: 10px;
      border-radius: 5px;
      cursor: pointer;
    }

    button:hover {
      background-color: #0056b3;
    }

    #resultTable {
      width: 100%;
      background-color: #fff;
      padding: 20px;
      border-radius: 10px;
      box-shadow: 0 0 20px rgba(0, 0, 0, 0.1);
    }

    table {
      width: 100%;
      border-collapse: collapse;
    }

    th, td {
      border-bottom: 1px solid #ddd;
      padding: 8px;
      text-align: left;
    }

    th {
      background-color: #007bff;
      color: #fff;
    }
  </style>
</head>
<body>
  <div id="scannerContainer">
    <video id="preview"></video>
    <button onclick="startScanner()">Start Scanner</button>
    <button onclick="closeScanner()">Close Scanner</button>
  </div>
  <table id="resultTable">
    <thead>
      <tr>
        <th>Scanned Content</th>
      </tr>
    </thead>
    <tbody id="resultBody"></tbody>
  </table>
  <script>
    let scanner = new Instascan.Scanner({ video: document.getElementById('preview') });
    let scannedContent = new Set();
    let resultTable = document.getElementById('resultTable');
    let resultBody = document.getElementById('resultBody');

    function startScanner() {
      scanner.addListener('scan', function (content) {
        if (!scannedContent.has(content)) {
          displayResult(content);
          scannedContent.add(content);
        }
      });
      
      Instascan.Camera.getCameras().then(function (cameras) {
        if (cameras.length > 0) {
          scanner.start(cameras[0]);
        } else {
          console.error('No cameras found.');
        }
      }).catch(function (e) {
        console.error(e);
      });
    }

    function closeScanner() {
      scanner.stop();
    }

    function displayResult(content) {
      let newRow = resultBody.insertRow();
      let cell = newRow.insertCell();
      cell.appendChild(document.createTextNode(content));
      resultTable.style.display = 'table';
    }
  </script>
</body>
</html>
