import{u as c,o as i,l as d,w as r,b as e,d as t,H as u,c as f,t as _,f as p,e as a,i as b,n as w,s as g}from"./app.cea855f7.js";import{_ as x}from"./Button.06d19c4a.js";import{_ as h}from"./Guest.38aaaf1d.js";import{_ as V}from"./Input.50e47f58.js";import{_ as v}from"./Label.a97b3341.js";import{_ as y}from"./ValidationErrors.b5d968ca.js";const k=a("div",{class:"mb-4"},[a("h2",{class:"font-bold mb-5 mt-2"},"Forgot Password")],-1),N={key:0,class:"mb-4 font-medium text-sm text-green-600"},$=["onSubmit"],B={class:"flex items-center justify-center mt-4"},q={__name:"ForgotPassword",props:{status:String},setup(o){const s=c({email:""}),l=()=>{s.post(route("password.email"))};return(F,m)=>(i(),d(h,null,{default:r(()=>[e(t(u),{title:"Forgot Password"}),k,o.status?(i(),f("div",N,_(o.status),1)):p("",!0),e(y,{class:"mb-4"}),a("form",{onSubmit:g(l,["prevent"])},[a("div",null,[e(v,{for:"email",value:"Email"}),e(V,{id:"email",type:"email",class:"mt-1 block w-full",modelValue:t(s).email,"onUpdate:modelValue":m[0]||(m[0]=n=>t(s).email=n),required:"",autofocus:"",autocomplete:"username"},null,8,["modelValue"])]),a("div",B,[e(x,{class:w(["w-full h-10 items-center justify-center",{"opacity-25":t(s).processing}]),disabled:t(s).processing},{default:r(()=>[b(" Next ")]),_:1},8,["class","disabled"])])],40,$)]),_:1}))}};export{q as default};