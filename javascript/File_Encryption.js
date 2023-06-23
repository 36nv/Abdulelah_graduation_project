  function encryptFile() {//الداله الخاصه بتشفير الملفات 
    const fileInput = document.getElementById('fileInput');
    const file = fileInput.files[0];// الحصول على الملف 

    if (!file || file.type !== 'text/plain') {
      alert('يرجى اختيار ملف نصي بصيغة TXT فقط');//فقط txt  اجبار المستخدم على ادخال ملفات من نوع
      return;
    }

    const reader = new FileReader();
    reader.onload = function (e) {
      const fileContent = e.target.result;// قراء الملف
      const encryptedContent = CryptoJS.AES.encrypt(
        fileContent,
        'password_here'
      ).toString();
 // CryptoJS تشفير المحتوى باستخدام مكتبه 
      const encryptedFile = new Blob([encryptedContent], {
        type: 'text/plain',
      });
      const downloadLink = document.createElement('a');
      downloadLink.href = URL.createObjectURL(encryptedFile);// انشاء رابط لتنزيل الملف بعد التشفير 
      downloadLink.download = 'encrypted_file.txt';// اختيار اسم الملف
      downloadLink.click();// تثبيت الملف
    };
    reader.readAsText(file);
  }

  function decryptFile() {//الداله الخاصه بفك تشفير الملفات 
    const fileInput = document.getElementById('fileInput');
    const file = fileInput.files[0];// الحصول على الملف 

    if (!file || file.type !== 'text/plain') {
      alert('يرجى اختيار ملف نصي بصيغة TXT فقط');//فقط txt  اجبار المستخدم على ادخال ملفات من نوع
      return;
    }

    const reader = new FileReader();
    reader.onload = function (e) {
      const fileContent = e.target.result;// قراء الملف
      const decryptedContent = CryptoJS.AES.decrypt(  // CryptoJS فك تشفير المحتوى باستخدام مكتبه 
        fileContent,
        'password_here'
      ).toString(CryptoJS.enc.Utf8);

      const decryptedFile = new Blob([decryptedContent], {
        type: 'text/plain',
      });
      const downloadLink = document.createElement('a');
      downloadLink.href = URL.createObjectURL(decryptedFile);// انشاء رابط لتنزيل الملف بعد فك التشفير 
      downloadLink.download = 'decrypted_file.txt';// اختيار اسم الملف
      downloadLink.click();// تثبيت الملف
    };
    reader.readAsText(file);
  }