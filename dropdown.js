 var cityLists = new Array(5) 
 cityLists["empty"] = ["Select a City"]; 
 cityLists["NY"] = ["Brooklyn", "Manhattan", "Queens", "Bronx", "Long Island","Others"]; 
 cityLists["NJ"] = ["Jersy City", "Newark", "New Port","Others"];  
 cityLists["CA"] = ["California"]; 
 
 var regionLists = new Array(12) 
 regionLists["empty"] = ["Select hometown"]; 
 //regionLists["IN"] = ["New Delhi", "Mumbai", "Nashik", "Kanpur", "Nagpur", "Orissa", "Bangalore", "Surat", "Chennai", "Tamil Nadu", "Kerala"]; 
 regionLists["IN"] = ["Andhra Pradesh", "Arunachal Pradesh", "Assam", "Bihar", "Chhattisgarh", "Goa", "Gujarat", "Haryana", "Himachal Pradesh", "Jammu and Kashmir","Jharkhand","Karnataka","Kerala","Madhya Pradesh", "Maharashtra","Manipur","Meghalaya","Mizoram","Nagaland","Delhi","Orissa", "Punjab", "Rajasthan", "Sikkim", "Tamil Nadu", "Tripura", "Uttar Pradesh", "Uttarakhand","West Bengal", "Others"];
 regionLists["IT"] = ["L.Aquila","Aosta", "Bari", "Potenza", "Catanzaro", "Naples", "Bologna", "Trieste", "Rome", "Genoa", "Milan", "Ancona", "Campobasso", "Turin", "Cagliari", "Palermo", "Florence", "Trento", "Perugia", "Venice", "Others"]; 
 regionLists["CN"] = ["Anhui", "Beijing", "Chongqing", "Fujian", "Gansu", "GuangDong", "Guangxi", "Guizhou", "Haerbin", "HeBei", "Henan", "Hubei", "Hunan", "JiangSu", "JiangXi", "Jilin", "LiaoNing", "Neimenggu", "Ningxia", "Qinhai", "Shanghai", "Shandong", "ShanXi", "TianJing", "Tibet", "Xinjiang", "ZheJiang",  "Hongkong", "Macau", "Others"]; 
 regionLists["TK"] = ["Istanbul", "Ankara", "Izmir", "Bursa", "Adana", "Gaziantep", "Konya", "Antalya", "Mersin", "Kayseri", "Eskisehir", "Urfa", "Malatya", "Erzurum", "Samsun", "Others"]; 
 regionLists["JP"] = ["Tokyo", "Yokohama", "Osaka", "Nagoya", "Sapporo", "Kobe", "Kyoto", "Fukuoka", "Kawasaki", "Saotama", "Hiroshima", "Sendai", "Kitakyushu", "Others"]; 
 regionLists["KO"] = ["Seoul", "Bushan", "Daegu", "Incheon", "Gwangju", "Daejeon", "Ulsan", "Sejong", "Others"];
 regionLists["TW"] = ["Kaohsiung City", "Kaohsiung County", "Hualien County", "Chiayi City", "Chiayi County", "Keelung City", "Kinmen County", "Lienchiang County", "Miaoli County", "Nantou County", "Penghu County", "Pingtung County", "Taipei City", "Taipei County", "Taitung County", "Tainan City", "Tainan County", "Taizhong City", "Taizhong County", "Taoyuan County", "Hsinchu City", "Hsinchu County", "llan County", "Yunlin County","Changhua County"];
 regionLists["MX"] = ["New Mexico City"]; 
 regionLists["US"] = ["California", "New York", "Arizona","Illinois","Nevada","Texas","Florida","Washington State","Pennsv","Kansas","Oregon","Virginia","Missouri", "Colorado", "Nebraska", "Rhode Island", "Massachusetts", "Vermont", "Iowa", "Michigan", "Idaho", "Montana", "North Dakota", "South Dakota", "Ohio", "Kentucky", "North Carolina", "South Carolina", "Geogia", "Alabama", "Mississippi", "Tenessee", "Louisiana", "Arkansas", "Indiana", "West Virginia", "Connecticut", "New Jersy", "Delaware", "District of Columbia", "New Hamsphire", "Maine", "Maryland"]; 
 regionLists["UK"] = ["London", "Liverpool", "South Hampton"]; 
 regionLists["SP"] = ["Madrid", "Barcelona", "Valencia"]; 
 
 var articleLists = new Array(4) 
 articleLists["empty"] = ["Select a Type"]; 
 articleLists["Electronics"] = ["Laptop", "Computer", "PC accessory", "Printer|Scanner", "Camera", "Air Conditioning", "Mobilephone", "TV Screen", "Play Station", "Electronic Fan", "Heater", "Shaver", "MP3", "Light|Lamp", "E-Reader", "Microwave","Speaker","Laundry Machine","Others"]; 
 articleLists["Books"] = ["Textbook", "Novel", "Magzine","Others"];
 articleLists["Costume"] = ["Clothes", "Pants", "Shorts", "Cap/Hat", "Shoes", "Shirts","Others"];
 articleLists["Transports"] = ["Vehicle", "Bicycle","Others"];
 articleLists["Furniture"] = ["Mattress", "Bed", "Closet", "Dinning Table", "Chairs","Others"];
 articleLists["Instruments"] = ["Guitar", "Voilin", "Drum","Others"];
 articleLists["Cosmetics"] = ["Shower Gel", "Shampoo", "Perfume", "Face Gel","Others"];
 articleLists["CardTickets"] = ["Metro Tickets", "LiveShow Tickets", "Discount Coupon","Others"];
 
 function cityChange(selectObj) { 
 var idx = selectObj.selectedIndex; 
 var which = selectObj.options[idx].value; 
 cList = cityLists[which]; 
 var cSelect = document.getElementById("ccity"); 
 var len=cSelect.options.length; 
 while (cSelect.options.length > 0) { 
 cSelect.remove(0); 
 } 
 var newOption; 
 for (var i=0; i<cList.length; i++) { 
 newOption = document.createElement("option"); 
 newOption.value = cList[i];  
 newOption.text=cList[i]; 

 try { 
 cSelect.add(newOption);  // this will fail in DOM browsers but is needed for IE 
 } 
 catch (e) { 
 cSelect.appendChild(newOption); 
 } 
 } 
 } 
 
 function regionChange(selectObj) { 
 var idx = selectObj.selectedIndex; 
 var which = selectObj.options[idx].value; 
 cList = regionLists[which]; 
 
 var cSelect = document.getElementById("fregion"); 
 var len=cSelect.options.length; 
 while (cSelect.options.length > 0) { 
 cSelect.remove(0); 
 } 
 var newOption; 

 for (var i=0; i<cList.length; i++) { 
 newOption = document.createElement("option"); 
 newOption.value = cList[i];  // assumes option string and value are the same 
 newOption.text=cList[i]; 

 try { 
 cSelect.add(newOption);  // this will fail in DOM browsers but is needed for IE 
 } 
 catch (e) { 
 cSelect.appendChild(newOption); 
 } 
 } 
 } 
 
 function articleChange(selectObj) { 
 var idx = selectObj.selectedIndex; 
 var which = selectObj.options[idx].value; 
 aList = articleLists[which]; 
 
 var aSelect = document.getElementById("aname"); 
 var len=aSelect.options.length; 
 while (aSelect.options.length > 0) { 
 aSelect.remove(0); 
 } 
 var newOption; 

 for (var i=0; i<aList.length; i++) { 
 newOption = document.createElement("option"); 
 newOption.value = aList[i];  // assumes option string and value are the same 
 newOption.text = aList[i]; 

 try { 
 aSelect.add(newOption);  // this will fail in DOM browsers but is needed for IE 
 } 
 catch (e) { 
 aSelect.appendChild(newOption); 
 } 
 } 
 } 