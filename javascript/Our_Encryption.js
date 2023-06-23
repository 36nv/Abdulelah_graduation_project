const substitutionKey = {  //q  الناتج هوا الحرف  a من خلال المصفوفه التاليه يت استبدال الاحرف مثلا اذا تم اداخل الحرف 
    'a': 'q', 'b': 'w', 'c': 'e', 'd': 'r', 'e': 't',
    'f': 'y', 'g': 'u', 'h': 'i', 'i': 'o', 'j': 'p',
    'k': 'a', 'l': 's', 'm': 'd', 'n': 'f', 'o': 'g',
    'p': 'h', 'q': 'j', 'r': 'k', 's': 'l', 't': 'z',
    'u': 'x', 'v': 'c', 'w': 'v', 'x': 'b', 'y': 'n',
    'z': 'm' ,'1':'0','2':'1','3':'2','4':'3','5':'4',
    '6':'5','7':'6','8':'7','9':'8','0':'9'
  };

  function encrypt() { // الداله الخاصه بالتشفير حيث تستبدل الحرف المدخل بالحرف الذي تم تعيينه من خلال المصوفه السابقه
    const inputText = document.getElementById('text-input').value;

    const inputChars = inputText.toLowerCase().split('');

    const outputChars = inputChars.map(char => {
      return substitutionKey[char] || char;
    });
  // يتم عرض المخرج للمستخدم في خانه المخرجات 
    const outputText = outputChars.join('');
    document.getElementById('output').value = outputText;
  }

  function decrypt() {// الداله الخاصه بفك التشفير حيث يتم فك التشفير من خلال النص المدخل ويتم ارجاعه من خلال المفوفه السابقه
    const inputText = document.getElementById('text-input').value;

    const inputChars = inputText.toLowerCase().split('');

    const outputChars = inputChars.map(char => {
      for (let key in substitutionKey) {
        if (substitutionKey[key] === char) {
          return key;
        }
      }
      return char;
    });
  // يتم عرض المخرج للمستخدم في خانه المخرجات 

    const outputText = outputChars.join('');
    document.getElementById('output').value = outputText;
  }