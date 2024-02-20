import{p as N,u as S,q as j,a as c,o as d,l as y,w as a,b as o,e as n,t as u,d as t,s as b,i as k,c as g,f as F,n as A,r as T,H as U,h as D,F as I,L as $}from"./app.cea855f7.js";import{_ as L}from"./Authenticated.d169710d.js";import{_ as B}from"./Input.50e47f58.js";import{_ as x}from"./Button.06d19c4a.js";import{u as H}from"./useAlerts.6e7215ec.js";const E=N("countries",{state:()=>({dialog:!1,isEdit:!1,form:S({id:"",name:"",image:""})})}),q={class:"text-h6"},z={for:"inputTag",class:"cursor-pointer bg-gray-200 py-2 px-2 rounded-lg flex justify-start items-center space-x-2"},M={key:0,id:"imageName",class:"text-black"},O={key:1},Y={key:0,class:"text-xs mx-1 mt-1 text-red-500"},G={class:"flex space-x-4 pt-5"},J=n("p",{class:"text-black"},"Cancel",-1),K={__name:"AddCountry",setup(w){const e=E(),r=j(""),h=p=>{const l=p.target.files[0];r.value=l.name,e.form.image=l},C=()=>{e.form.post(route("countries.store"),{preserveScroll:!0,onSuccess:()=>{e.form.reset(),e.dialog=!1},onFinish:()=>{e.form.reset(),r.value=""}})},f=()=>{e.form.post(route("countries.update",{id:e.form.id}),{preserveScroll:!0,onSuccess:()=>{e.form.reset(),e.dialog=!1,e.isEdit=!1},onFinish:()=>{e.form.reset()}})};return(p,l)=>{const i=c("VCardTitle"),_=c("v-icon"),m=c("VContainer"),v=c("VCard"),V=c("VDialog");return d(),y(V,{modelValue:t(e).dialog,"onUpdate:modelValue":l[4]||(l[4]=s=>t(e).dialog=s),persistent:"","max-width":"290"},{default:a(()=>[o(v,{class:"w-80"},{default:a(()=>[o(i,null,{default:a(()=>[n("span",q,u(t(e).isEdit?"Edit Country":"Add Country"),1)]),_:1}),o(m,null,{default:a(()=>[n("form",{onSubmit:l[3]||(l[3]=b(s=>t(e).isEdit?f():C(),["prevent"])),class:"space-y-2"},[n("label",z,[o(_,{class:"cursor-pointer",color:"#8B8B8B"},{default:a(()=>[k("mdi-camera")]),_:1}),n("div",null,[r.value?(d(),g("span",M,u(r.value),1)):(d(),g("p",O,"Select Image"))]),n("input",{id:"inputTag",type:"file",class:"hidden py-2",onChange:l[0]||(l[0]=s=>h(s))},null,32)]),o(B,{placeholder:"Name",class:"w-full py-2 px-3",modelValue:t(e).form.name,"onUpdate:modelValue":l[1]||(l[1]=s=>t(e).form.name=s)},null,8,["modelValue"]),t(e).form.errors.name?(d(),g("p",Y,u(t(e).form.errors.name),1)):F("",!0),n("div",G,[o(x,{onClick:l[2]||(l[2]=b(s=>t(e).dialog=!1,["prevent"])),secondary:"",type:"button",class:"w-full flex items-center justify-center"},{default:a(()=>[J]),_:1}),o(x,{class:A([{"opacity-25":t(e).form.processing},"w-full flex items-center justify-center"]),disabled:t(e).form.processing},{default:a(()=>[k(u(t(e).isEdit?"Update":"Submit"),1)]),_:1},8,["class","disabled"])])],32)]),_:1})]),_:1})]),_:1},8,["modelValue"])}}},P={class:"flex flex-row justify-between items-center w-full py-2 pb-5"},Q={class:"flex space-x-2"},R={class:""},W={class:"py-2"},X={class:"flex grid-col-4 gap-4 cursor-pointer flex-wrap"},Z={class:"w-64 h-36 flex justify-center items-center overflow-hidden"},ee=["src"],te={class:"flex justify-between"},se={class:"py-3 px-2 text-lg"},ce={__name:"Countries",props:{countries:Object},setup(w){const e=E(),r=S({search:""}),{alert:h}=H();T({}),j(!0);const C=l=>{h(null,"this action will delete country",null,"Yes , do it!").then(({isConfirmed:i})=>i?e.form.delete(route("countries.delete",{id:l})):null)},f=()=>{r.get(route("countries"))},p=()=>{r.search="",f()};return(l,i)=>{const _=c("VIcon"),m=c("VBtn"),v=c("VCardActions"),V=c("VCard");return d(),y(L,null,{default:a(()=>[o(t(U),{title:"Countries"}),n("div",P,[n("form",{onSubmit:i[2]||(i[2]=b(s=>f(),["prevent"]))},[n("div",Q,[o(B,{type:"search",class:"bg-slate-200",placeholder:"Search Country...",modelValue:t(r).search,"onUpdate:modelValue":i[0]||(i[0]=s=>t(r).search=s)},null,8,["modelValue"]),n("div",R,[o(x,{type:"submit",class:"h-10 w-10 flex items-center justify-center"},{default:a(()=>[o(_,{icon:"mdi-magnify"})]),_:1})]),o(x,{type:"submit",onClick:i[1]||(i[1]=s=>p()),class:"h-10 w-10 flex items-center justify-center active:bg-slate-300",secondary:""},{default:a(()=>[o(_,{color:"black",icon:"mdi-close"})]),_:1})])],32),n("div",W,[o(m,{onClick:i[3]||(i[3]=()=>{t(e).form.reset(),t(e).dialog=!0}),icon:"mdi-plus",color:"black",class:"ml-auto"})])]),n("div",X,[(d(!0),g(I,null,D(w.countries,s=>(d(),y(V,{class:"w-64 hover:shadow-xl",key:s.id},{default:a(()=>[o(t($),{href:`/${s.id}/cities`},{default:a(()=>[n("div",Z,[n("img",{class:"min-w-full min-h-full",src:s.image},null,8,ee)])]),_:2},1032,["href"]),n("div",te,[o(t($),{href:`/${s.id}/cities`},{default:a(()=>[n("h1",se,u(s.name),1)]),_:2},1032,["href"]),o(v,null,{default:a(()=>[o(m,{onClick:oe=>C(s.id),text:"",icon:"mdi-delete"},null,8,["onClick"]),o(m,{onClick:()=>{t(e).form.id=s.id,t(e).form.name=s.name,t(e).form.image=s.image,t(e).dialog=!0,t(e).isEdit=!0},text:"",icon:"mdi-pencil"},null,8,["onClick"])]),_:2},1024)])]),_:2},1024))),128))]),o(K)]),_:1})}}};export{ce as default};
