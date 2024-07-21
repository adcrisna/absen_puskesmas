// resources/js/helpers/qrcode.js

import QRCode from "qrcode-generator";

export function generateQRCode(text, size = 200) {
    const qr = QRCode(0, "L");
    qr.addData(text);
    qr.make();
    return qr.createImgTag(size);
}
