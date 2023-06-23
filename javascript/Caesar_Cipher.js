function encrypt() {// الداله الخاصه بالتشفير من خلال شفره قيصر 
    var message = document.getElementById("message").value;// استلام النص المدخل وتخزينه في متغيير لتشفيرة
    var shift = parseInt(document.getElementById("shift").value);// استلام الرقم المدخل لتحديد مقدار الازاحه في حاله التشفير
    var result = "";// انشاء متغيير فارغ لاضافه النتيجه
    for (var i = 0; i < message.length; i++)//for يتم حساب عدد الاحرف المدخله من خلال العداد  i من خلال الحرف 
     {
      var charCode = message.charCodeAt(i);
      if (charCode >= 65 && charCode <= 90) //في يتم تحديد الحرف من خلالها واذا كان حرف كبير ام صغير في هذه الحاله يتم تحديد الحرف الكبير charCodeمن خلال الداله  
       {
        result += String.fromCharCode((charCode - 65 + shift) % 26 + 65); // من خلال العملية الحسابيه التاليه وباستخدام النص المدخل ومقدار الازاحه يتم التشفير
      } else if (charCode >= 97 && charCode <= 122) //في يتم تحديد الحرف من خلالها واذا كان حرف كبير ام صغير في هذه الحاله يتم تحديد الحرف الصغير charCodeمن خلال الداله  
      {
        result += String.fromCharCode((charCode - 97 + shift) % 26 + 97);// من خلال العملية الحسابيه التاليه وباستخدام النص المدخل ومقدار الازاحه يتم التشفير
      } else {
        result += message.charAt(i);// اخراج الناتج
      }
    }
    document.getElementById("output").value = result;// عرض الناتج للمستخدم
  }

  function decrypt() {// الداله الخاصه بفك التشفير من خلال شفره قيصر 
    var message = document.getElementById("message").value;// استلام النص المدخل وتخزينه في متغيير لتشفيرة
    var shift = parseInt(document.getElementById("shift").value);// استلام الرقم المدخل لتحديد مقدار الازاحه في حاله التشفير
    var result = "";// انشاء متغيير فارغ لاضافه النتيجه
    for (var i = 0; i < message.length; i++) {//for يتم حساب عدد الاحرف المدخله من خلال العداد  i من خلال الحرف 
      var charCode = message.charCodeAt(i);
      if (charCode >= 65 && charCode <= 90) {//في يتم تحديد الحرف من خلالها واذا كان حرف كبير ام صغير في هذه الحاله يتم تحديد الحرف الكبير charCodeمن خلال الداله  
        result += String.fromCharCode((charCode - 65 - shift + 26) % 26 + 65);// من خلال العملية الحسابيه التاليه وباستخدام النص المدخل ومقدار الازاحه يتم فك التشفير 
      } else if (charCode >= 97 && charCode <= 122) {//في يتم تحديد الحرف من خلالها واذا كان حرف كبير ام صغير في هذه الحاله يتم تحديد الحرف الصغير charCodeمن خلال الداله  
        result += String.fromCharCode((charCode - 97 - shift + 26) % 26 + 97);// من خلال العملية الحسابيه التاليه وباستخدام النص المدخل ومقدار الازاحه يتم فك التشفير 
      } else {
        result += message.charAt(i);// اخراج الناتج
      }
    }
    document.getElementById("output").value = result;// عرض الناتج للمستخدم
  }