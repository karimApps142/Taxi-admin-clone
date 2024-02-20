import{_ as h}from"./Authenticated.d169710d.js";import{r as g,a as b,o as k,c as w,b as s,d as p,H as B,w as o,F as v,e,t as i,i as l}from"./app.cea855f7.js";import{_ as c}from"./StatictsCard.33bb12f6.js";const N={class:"p-6 flex flex-col"},P={class:"bg-white p-4 rounded-lg flex space-x-2 flex-row items-center shadow-[0_4px_10px_rgba(0,0,0,0.15)] justify-between"},S={class:"flex flex-row items-center"},y=["src"],C={class:"ml-5",name:"name_email"},j={class:"text-xl sm:text-2xl"},R={class:"text-[#636363] text-md sm:text-lg text-normal"},T={class:"flex flex-row items-center justify-start space-x-0 flex-wrap mt-5"},V={class:"flex flex-col space-y-5"},D={class:"bg-white w-full mt-10 rounded-lg p-6 flex flex-col shadow-[0_4px_10px_rgba(0,0,0,0.15)] text-left"},E=e("h1",{class:"text-semibold text-lg"},"Personal Detail",-1),F={class:"flex flex-col grid-row-2 divide-y text-[#383838] mt-2"},H={class:"flex space-x-4 flex-row items-center h-12"},L=e("b",null," Name: ",-1),$={class:"flex space-x-4 flex-row items-center h-12"},O=e("b",null," Email: ",-1),q={class:"flex space-x-4 flex-row items-center h-12"},z=e("b",null," Phone: ",-1),A={class:"flex space-x-4 flex-row items-center"},G={class:"mt-2"},I=e("b",null," Push Token: ",-1),J={class:"flex space-x-4 flex-row items-center h-12"},K=e("b",null," Lattitude: ",-1),M={class:"flex space-x-4 flex-row items-center h-12"},Q=e("b",null," Longitude: ",-1),ee={__name:"RiderProfile",props:{rider:Object,totalBookings:String,currentBookings:String,completedBookings:String,cancelledBookings:String},setup(t){var a;const f=t;return g({tab:null}),(a=f.rider)==null||a.rider_active_booking,(U,W)=>{const n=b("v-icon");return k(),w(v,null,[s(p(B),{title:"Profile"}),s(h,{isBack:"",title:"Rider Profile"},{default:o(()=>{var r,d,u,m,x,_;return[e("main",N,[e("section",P,[e("div",S,[e("img",{src:(r=t.rider)==null?void 0:r.avatar,class:"h-28 rounded-full",alt:"driver image"},null,8,y),e("div",C,[e("h1",j,i((d=t.rider)==null?void 0:d.name),1),e("p",R,i((u=t.rider)==null?void 0:u.email),1)])]),e("p",null,[l(" Ride Status : "),e("span",null,i(t.rider.ride_status),1)])]),e("section",T,[s(c,{title:"Total Bookings",subtitle:t.totalBookings,icon:"mdi-car"},null,8,["subtitle"]),s(c,{title:"Current Bookings",subtitle:t.currentBookings,icon:"mdi-car"},null,8,["subtitle"]),s(c,{title:"Completed Bookings",subtitle:t.completedBookings,icon:"mdi-car"},null,8,["subtitle"]),s(c,{title:"Cancelled Bookings",subtitle:t.cancelledBookings,icon:"mdi-car"},null,8,["subtitle"])]),e("section",V,[e("div",D,[E,e("ul",F,[e("li",H,[s(n,null,{default:o(()=>[l("mdi-account")]),_:1}),e("p",null,[L,l(i(t.rider.name),1)])]),e("li",$,[s(n,null,{default:o(()=>[l("mdi-email")]),_:1}),e("p",null,[O,l(i(t.rider.email),1)])]),e("li",q,[s(n,null,{default:o(()=>[l("mdi-phone")]),_:1}),e("p",null,[z,l(i((m=t.rider.phone)!=null?m:"Null"),1)])]),e("li",A,[s(n,null,{default:o(()=>[l("mdi-account")]),_:1}),e("p",G,[I,l(i(t.rider.push_token?t.rider.push_token:"Null"),1)])]),e("li",J,[s(n,null,{default:o(()=>[l("mdi-earth")]),_:1}),e("p",null,[K,l(i((x=t.rider.lat)!=null?x:"Null"),1)])]),e("li",M,[s(n,null,{default:o(()=>[l("mdi-earth")]),_:1}),e("p",null,[Q,l(i((_=t.rider.lng)!=null?_:"Null"),1)])])])])])])]}),_:1})],64)}}};export{ee as default};