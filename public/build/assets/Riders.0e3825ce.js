import{p as J,u as A,r as j,a as f,o as u,l as B,w as r,b as o,e as l,t as m,d as e,s as N,c,f as _,n as V,i as M,H as q,F as U,J as G,h as R,L as K}from"./app.cea855f7.js";import{_ as O}from"./Authenticated.d169710d.js";import{T as Q}from"./Table.c99bc67c.js";import{_ as k}from"./Actions.5787c160.js";import{u as W}from"./useAlerts.6e7215ec.js";import{_ as $}from"./Button.06d19c4a.js";import{_ as h}from"./Input.50e47f58.js";import{_ as x}from"./Label.a97b3341.js";import{_ as X}from"./Pagination.765da988.js";const D=J("riders",{state:()=>({dialog:!1,isEdit:!1,showPassword:!1,form:A({id:"",name:"",email:"",phone:"",password:"",password_confirmation:""})})}),Z={class:"text-h6"},ee={key:0,class:"text-xs mx-1 mt-1 text-red-500"},se={key:1,class:"text-xs mx-1 mt-1 text-red-500"},te={key:2,class:"text-xs mx-1 mt-1 text-red-500"},oe={key:0,class:"flex flex-col mt-2"},le={class:"flex items-center relative"},ae={key:0,class:"text-xs mx-1 mt-1 text-red-500 w-52"},ne={key:1,class:"flex flex-col mt-2"},re={class:"flex items-center relative"},ie={key:0,class:"text-xs mx-1 mt-1 text-red-500"},ue={class:"flex items-center justify-end mt-8"},de=l("p",{class:"text-[#161515]"},"Cancel",-1),me={__name:"AddRider",setup(v){const s=D();j({});const y=()=>{s.form.post(route("riders.store"),{preserveScroll:!0,onSuccess:()=>{s.form.reset(),s.dialog=!1,s.isEdit=!1},onFinish:()=>{s.form.reset()}})};function g(){s.form.put(route("riders.update",{rider:s.form.id}),{preserveScroll:!0,onSuccess:()=>{s.form.reset(),s.dialog=!1,s.isEdit=!1}})}return(d,a)=>{const S=f("v-card-title"),p=f("v-icon"),b=f("v-container"),C=f("v-card"),P=f("v-dialog");return u(),B(P,{modelValue:e(s).dialog,"onUpdate:modelValue":a[9]||(a[9]=n=>e(s).dialog=n),persistent:"","max-width":"290"},{default:r(()=>[o(C,{class:"w-80"},{default:r(()=>[o(S,{class:""},{default:r(()=>[l("span",Z,m(e(s).isEdit?"Edit Rider":"Add Rider"),1)]),_:1}),o(b,null,{default:r(()=>[l("form",{onSubmit:a[8]||(a[8]=N(n=>e(s).isEdit?g():y(),["prevent"]))},[l("div",null,[o(x,{class:"",for:"name",value:"Name"}),o(h,{id:"name",type:"text",class:"mt-1 block w-full px-3",modelValue:e(s).form.name,"onUpdate:modelValue":a[0]||(a[0]=n=>e(s).form.name=n),autofocus:"",placeholder:"Name"},null,8,["modelValue"]),e(s).form.errors.name?(u(),c("p",ee,m(e(s).form.errors.name),1)):_("",!0),o(x,{class:"mt-2",for:"email",value:"Email"}),o(h,{id:"email",type:"email",class:"mt-1 block w-full px-3",modelValue:e(s).form.email,"onUpdate:modelValue":a[1]||(a[1]=n=>e(s).form.email=n),autofocus:"",placeholder:"Email"},null,8,["modelValue"]),e(s).form.errors.email?(u(),c("p",se,m(e(s).form.errors.email),1)):_("",!0),o(x,{class:"mt-2",for:"phone",value:"Phone"}),o(h,{id:"phone",type:"tel",class:"mt-1 block w-full px-3",modelValue:e(s).form.phone,"onUpdate:modelValue":a[2]||(a[2]=n=>e(s).form.phone=n),autofocus:"",placeholder:"Phone"},null,8,["modelValue"]),e(s).form.errors.phone?(u(),c("p",te,m(e(s).form.errors.phone),1)):_("",!0)]),e(s).isEdit?_("",!0):(u(),c("div",oe,[o(x,{value:"Password"}),l("div",le,[o(h,{class:"px-2 py-2 w-full",placeholder:"Password",type:e(s).showPassword?"text":"password",modelValue:e(s).form.password,"onUpdate:modelValue":a[3]||(a[3]=n=>e(s).form.password=n)},null,8,["type","modelValue"]),l("button",{type:"button",onClick:a[4]||(a[4]=n=>e(s).showPassword=!e(s).showPassword),class:"absolute right-2"},[o(p,{color:"grey-darken-1",icon:e(s).showPassword?"mdi-eye-off":"mdi-eye"},null,8,["icon"])])]),e(s).form.errors.password?(u(),c("p",ae,m(e(s).form.errors.password),1)):_("",!0)])),e(s).isEdit?_("",!0):(u(),c("div",ne,[o(x,{value:"Confirm Password"}),l("div",re,[o(h,{class:"px-2 py-2 w-full",placeholder:"Confirm Password",type:e(s).showPassword?"text":"password",modelValue:e(s).form.password_confirmation,"onUpdate:modelValue":a[5]||(a[5]=n=>e(s).form.password_confirmation=n)},null,8,["type","modelValue"]),l("button",{type:"button",onClick:a[6]||(a[6]=n=>e(s).showPassword=!e(s).showPassword),class:"absolute right-2"},[o(p,{color:"grey-darken-1",icon:e(s).showPassword?"mdi-eye-off":"mdi-eye"},null,8,["icon"])]),e(s).form.errors.password_confirmation?(u(),c("p",ie,m(e(s).form.errors.password_confirmation),1)):_("",!0)])])),l("div",ue,[o($,{onClick:a[7]||(a[7]=N(n=>e(s).dialog=!1,["prevent"])),type:"button",secondary:"",class:V(["w-full flex items-center justify-center mr-3",{"opacity-25":e(s).form.processing}]),disabled:e(s).form.processing},{default:r(()=>[de]),_:1},8,["class","disabled"]),o($,{class:V(["w-full flex items-center justify-center bg-[#161515]",{"opacity-25":e(s).form.processing}]),disabled:e(s).form.processing},{default:r(()=>[M(m(e(s).isEdit?"Update":"Submit"),1)]),_:1},8,["class","disabled"])])],32)]),_:1})]),_:1})]),_:1},8,["modelValue"])}}},ce={class:"flex flex-col"},fe={class:"flex"},pe={class:"flex space-x-2"},_e={class:"flex items-center bg-slate-200 pr-2 rounded-md focus:ring-1"},ve={class:""},he=l("thead",null,[l("tr",{class:"bg-[#1D1C1C] text-white"},[l("th",null,"image"),l("th",null,"Name"),l("th",null,"Email"),l("th",null,"Phone No"),l("th",null,"Status"),l("th",{class:"w-40"},"Action")])],-1),we={class:"p-2 pl-5 border-b-2 relative"},xe=["src"],ye={class:"p-2 pl-5 border-b-2 flex"},Ue={__name:"Riders",props:{riders:Array,search:Boolean,filter:String},setup(v){var n;const s=v,{alert:y}=W(),g=A({}),d=D(),a=w=>{y("Are You Sure",`Are you sure you want to ${w.status==="active"?"block":"unblock"} this rider`,null,"Yes , do it!").then(({isConfirmed:i})=>i?g.put(route("rider.status.change",{user:w}),{preserveScroll:!0,onSuccess:()=>{}}):null)},S=w=>{y("Are You Sure","Are you sure you want to delete rider",null,"Yes , do it!").then(({isConfirmed:i})=>i?g.delete(route("rider.delete",{id:w}),{preserveScroll:!0,onSuccess:()=>{}}):null)},p=A({filter:(n=s.filter)!=null?n:"",search:""}),b=()=>{p.get(route("riders"))},C=()=>{p.search="",b()},P=j({searchBy:[{title:"Name",value:"name"},{title:"Email",value:"email"},{title:"Phone",value:"phone"},{title:"Status",value:"status"}]});return(w,i)=>{const E=f("VIcon"),Y=f("v-radio"),z=f("v-radio-group"),L=f("v-list"),T=f("v-menu"),H=f("VBtn");return u(),c(U,null,[o(e(q),{title:"Riders"}),o(O,null,{default:r(()=>{var F;return[l("section",ce,[l("div",fe,[l("form",{onSubmit:i[3]||(i[3]=N(t=>b(),["prevent"])),class:"py-2"},[l("div",pe,[l("div",_e,[o(h,{type:"search",class:"bg-slate-200 focus:ring-0",placeholder:"Search Riders...",modelValue:e(p).search,"onUpdate:modelValue":i[0]||(i[0]=t=>e(p).search=t)},null,8,["modelValue"]),o(T,null,{activator:r(({props:t})=>[o(E,G({icon:"mdi-filter-variant",class:"cursor-pointer"},t),null,16)]),default:r(()=>[o(L,{class:"w-40"},{default:r(()=>[o(z,{modelValue:e(p).filter,"onUpdate:modelValue":i[1]||(i[1]=t=>e(p).filter=t)},{default:r(()=>[(u(!0),c(U,null,R(P.searchBy,t=>(u(),B(Y,{key:t,label:t.title,value:t.value},null,8,["label","value"]))),128))]),_:1},8,["modelValue"])]),_:1})]),_:1})]),l("div",ve,[o($,{type:"submit",class:"h-10 w-10 flex items-center justify-center"},{default:r(()=>[o(E,{icon:"mdi-magnify"})]),_:1})]),o($,{type:"submit",onClick:i[2]||(i[2]=t=>C()),class:"h-10 w-10 flex items-center justify-center bg-slate-200 hover:bg-slate-300 active:bg-slate-300",secondary:""},{default:r(()=>[o(E,{color:"black",icon:"mdi-close"})]),_:1})])],32),o(H,{onClick:i[4]||(i[4]=()=>{e(d).form.reset(),e(d).isEdit=!1,e(d).dialog=!0}),icon:"mdi-plus",color:"black",class:"ml-auto"})]),o(Q,{class:"mt-2 border rounded"},{default:r(()=>[he,l("tbody",null,[(u(!0),c(U,null,R(v.search?v.riders:v.riders.data,t=>(u(),c("tr",{key:t.sender,class:"cursor-pointer"},[l("td",we,[l("div",{class:V(`w-3 h-3 absolute top-1 z-10 rounded-full ${t.active_status==="online"?"bg-green-700":"bg-red-500"}`)},null,2),l("img",{src:t.avatar,class:"w-10 h-10 rounded-full bg-gray-400"},null,8,xe)]),l("td",null,m(t.name),1),l("td",null,m(t.email),1),l("td",null,m(t.phone),1),l("td",null,[l("span",{class:V(["text-white px-2 rounded font-sans capitalize",t.status==="active"?"bg-green-700":"bg-[#FF0000]"])},m(t.status),3)]),l("td",ye,[o(k,{isStatus:t.status,onClick:I=>a(t)},null,8,["isStatus","onClick"]),o(k,{isDelete:!0,onClick:I=>S(t.id)},null,8,["onClick"]),o(k,{isEdit:!0,onClick:()=>{e(d).form.id=t==null?void 0:t.id,e(d).form.name=t==null?void 0:t.name,e(d).form.email=t==null?void 0:t.email,e(d).form.phone=t==null?void 0:t.phone,e(d).form.password=t==null?void 0:t.password,e(d).form.password_confirmation=t==null?void 0:t.password,e(d).isEdit=!0,e(d).dialog=!0}},null,8,["onClick"]),o(e(K),{href:"/rider",data:{slug:t.slug},as:"button"},{default:r(()=>[o(k,{isView:!0})]),_:2},1032,["data"])])]))),128))])]),_:1}),v.search?_("",!0):(u(),B(X,{key:0,links:(F=v.riders)==null?void 0:F.links},null,8,["links"]))]),o(me)]}),_:1})],64)}}};export{Ue as default};