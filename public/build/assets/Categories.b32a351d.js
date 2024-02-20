import{_ as F}from"./Authenticated.d169710d.js";import{_}from"./Input.50e47f58.js";import{_ as C}from"./Label.a97b3341.js";import{_ as v}from"./Button.06d19c4a.js";import{p as N,u as O,r as $,a as f,o as u,l as B,w as n,b as r,e as t,d as e,c as m,t as c,f as x,n as g,i as S,j as E,H as A,F as k,h as H}from"./app.cea855f7.js";import{_ as w}from"./Actions.5787c160.js";import{T as Y}from"./Table.c99bc67c.js";import{u as z}from"./useAlerts.6e7215ec.js";import{_ as L}from"./Pagination.765da988.js";const j=N("categories",{state:()=>({dialog:!1,mode:"add",form:O({id:"",title:"",min_price:"",max_price:""})})}),q=t("span",{class:"text-h6"},"New Category",-1),G={key:0,class:"text-xs mx-1 mt-1 text-red-500"},I={class:"flex justify-between"},J={key:0,class:"text-xs mx-1 mt-1 text-red-500"},K={key:0,class:"text-xs mx-1 mt-1 text-red-500"},Q={class:"flex items-center justify-end mt-6"},R=t("p",{class:"text-[#23df00]"},"Cancel",-1),W={__name:"AddCategory",setup(y){$({});const s=j(),l=()=>{s.form.post(route("categories.store"),{preserveScroll:!0,onSuccess:()=>{s.form.reset(),s.dialog=!1},onFinish:()=>{s.form.reset()}})};return(b,i)=>{const V=f("v-card-title"),h=f("v-container"),p=f("v-card"),a=f("v-dialog");return u(),B(a,{modelValue:e(s).dialog,"onUpdate:modelValue":i[4]||(i[4]=d=>e(s).dialog=d)},{default:n(()=>[r(p,{class:"w-80"},{default:n(()=>[r(V,null,{default:n(()=>[q]),_:1}),r(h,null,{default:n(()=>[t("form",null,[t("div",null,[r(C,{for:"title",value:"Title"}),r(_,{id:"title",type:"text",class:"mt-1 block w-full",modelValue:e(s).form.title,"onUpdate:modelValue":i[0]||(i[0]=d=>e(s).form.title=d),autofocus:"",placeholder:"Category title"},null,8,["modelValue"]),e(s).form.errors.title?(u(),m("p",G,c(e(s).form.errors.title),1)):x("",!0)]),t("div",I,[t("div",null,[r(_,{class:"mt-2 py-2 px-2 w-[140px]",type:"text",modelValue:e(s).form.min_price,"onUpdate:modelValue":i[1]||(i[1]=d=>e(s).form.min_price=d),placeholder:"Min Price"},null,8,["modelValue"]),e(s).form.errors.min_price?(u(),m("p",J,c(e(s).form.errors.min_price),1)):x("",!0)]),t("div",null,[r(_,{class:"mt-2 py-2 px-2 w-[140px]",type:"text",modelValue:e(s).form.max_price,"onUpdate:modelValue":i[2]||(i[2]=d=>e(s).form.max_price=d),placeholder:"Max Price"},null,8,["modelValue"]),e(s).form.errors.max_price?(u(),m("p",K,c(e(s).form.errors.max_price),1)):x("",!0)])]),t("div",Q,[r(v,{onClick:i[3]||(i[3]=d=>e(s).dialog=!1),type:"button",class:g(["w-full flex items-center justify-center bg-white mr-3",{"opacity-25":e(s).form.processing}]),disabled:e(s).form.processing},{default:n(()=>[R]),_:1},8,["class","disabled"]),r(v,{onClick:l,class:g(["w-full flex items-center justify-center bg-[#23df00]",{"opacity-25":e(s).form.processing}]),disabled:e(s).form.processing},{default:n(()=>[S(" Submit ")]),_:1},8,["class","disabled"])])])]),_:1})]),_:1})]),_:1},8,["modelValue"])}}},X={class:"mt-3"},Z=t("thead",{class:"bg-[#2e2c2b] text-white"},[t("tr",null,[t("th",{class:"text-left"},"Title"),t("th",{class:"text-left"},"Minimum Price"),t("th",{class:"text-left"},"Maximum Price"),t("th",{class:"text-left"},"Status"),t("th",{class:"text-right w-20"},"Actions")])],-1),ee={class:"flex flex-row"},te=t("span",{class:"text-h6"},"Edit Category",-1),le={key:0,class:"text-xs mx-1 mt-1 text-red-500"},oe={class:"flex justify-between"},se={key:0,class:"text-xs mx-1 mt-1 text-red-500"},re={key:0,class:"text-xs mx-1 mt-1 text-red-500"},ae={class:"flex items-center justify-end mt-6"},ne=t("p",{class:"text-[#23df00]"},"Cancel",-1),ge={__name:"Categories",props:{categories:Object},setup(y){const s=$({dailog:!1}),l=j(),{alert:b}=z(),i=p=>{b(null,"this action will change category status",null,"Yes , do it!").then(({isConfirmed:a})=>a?l.form.put(route("categories.status",{category:p}),{preserveScroll:!0,onSuccess:()=>{}}):null)};E(p=>p==="active"?"text-green-400":"text-red-400");const V=p=>{b(null,"this action will delete category",null,"Yes , do it!").then(({isConfirmed:a})=>a?l.form.delete(route("categories.delete",{id:p})):null)},h=()=>{l.form.post(route("categories.update",{id:l.form.id}),{onSuccess:()=>{l.form.reset(),s.dialog=!1},onFinish:()=>{l.form.reset()}})};return(p,a)=>{const d=f("v-btn"),U=f("v-card-title"),M=f("v-container"),P=f("v-card"),T=f("v-dialog");return u(),m(k,null,[r(e(A),{title:"Categories"}),r(F,null,{default:n(()=>[r(d,{onClick:a[0]||(a[0]=()=>{e(l).form.reset(),e(l).form.clearErrors(),e(l).dialog=!0}),color:"#23df00",icon:"mdi-plus",class:"ml-auto mr-2 text-white"}),t("div",X,[r(Y,{class:"border rounded"},{default:n(()=>[Z,t("tbody",null,[(u(!0),m(k,null,H(y.categories.data,o=>(u(),m("tr",{key:o.id,class:"cursor-pointer"},[t("td",null,c(o.title),1),t("td",null,c(o.min_price),1),t("td",null,c(o.max_price),1),t("td",null,[t("span",{class:g(["text-white px-2 rounded font-serif",o.status==="active"?"bg-green-700":"bg-red-700"])},c(o.status),3)]),t("td",ee,[r(w,{isEdit:!0,onClick:()=>{e(l).form.id=o==null?void 0:o.id,e(l).form.title=o==null?void 0:o.title,e(l).form.min_price=o==null?void 0:o.min_price,e(l).form.max_price=o==null?void 0:o.max_price,s.dialog=!0}},null,8,["onClick"]),r(w,{isStatus:o.status,onOnStatus:D=>i(o.id)},null,8,["isStatus","onOnStatus"]),r(w,{isDelete:!0,onOnDelete:D=>V(o.id)},null,8,["onOnDelete"])])]))),128))])]),_:1}),r(L,{links:y.categories.links},null,8,["links"]),r(W)]),t("template",null,[r(T,{modelValue:s.dialog,"onUpdate:modelValue":a[5]||(a[5]=o=>s.dialog=o)},{default:n(()=>[r(P,{class:"w-80"},{default:n(()=>[r(U,null,{default:n(()=>[te]),_:1}),r(M,null,{default:n(()=>[t("form",null,[t("div",null,[r(C,{for:"title",value:"Title"}),r(_,{id:"title",type:"text",class:"mt-1 block w-full",modelValue:e(l).form.title,"onUpdate:modelValue":a[1]||(a[1]=o=>e(l).form.title=o),autofocus:"",placeholder:"Category title"},null,8,["modelValue"]),e(l).form.errors.title?(u(),m("p",le,c(e(l).form.errors.title),1)):x("",!0)]),t("div",oe,[t("div",null,[r(_,{class:"mt-2 py-2 px-2 w-[140px]",type:"text",modelValue:e(l).form.min_price,"onUpdate:modelValue":a[2]||(a[2]=o=>e(l).form.min_price=o),placeholder:"Min Price"},null,8,["modelValue"]),e(l).form.errors.min_price?(u(),m("p",se,c(e(l).form.errors.min_price),1)):x("",!0)]),t("div",null,[r(_,{class:"mt-2 py-2 px-2 w-[140px]",type:"text",modelValue:e(l).form.max_price,"onUpdate:modelValue":a[3]||(a[3]=o=>e(l).form.max_price=o),placeholder:"Max Price"},null,8,["modelValue"]),e(l).form.errors.max_price?(u(),m("p",re,c(e(l).form.errors.max_price),1)):x("",!0)])]),t("div",ae,[r(v,{onClick:a[4]||(a[4]=o=>s.dialog=!1),type:"button",class:g(["w-full flex items-center justify-center bg-white mr-3",{"opacity-25":e(l).form.processing}]),disabled:e(l).form.processing},{default:n(()=>[ne]),_:1},8,["class","disabled"]),r(v,{onClick:h,class:g(["w-full flex items-center justify-center bg-[#23df00]",{"opacity-25":e(l).form.processing}]),disabled:e(l).form.processing},{default:n(()=>[S(" Update ")]),_:1},8,["class","disabled"])])])]),_:1})]),_:1})]),_:1},8,["modelValue"])])]),_:1})],64)}}};export{ge as default};