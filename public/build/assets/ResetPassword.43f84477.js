import{u,o as c,l as f,w as m,b as o,d as e,H as _,e as r,i as w,n as V,s as b}from"./app.cea855f7.js";import{_ as k}from"./Button.06d19c4a.js";import{_ as v}from"./Guest.38aaaf1d.js";import{_ as l}from"./Input.50e47f58.js";import{_ as i}from"./Label.a97b3341.js";import{_ as x}from"./ValidationErrors.b5d968ca.js";const y=["onSubmit"],P={class:"mt-4"},$={class:"mt-4"},g={class:"flex items-center justify-end mt-4"},h={__name:"ResetPassword",props:{email:String,token:String},setup(n){const d=n,s=u({token:d.token,email:d.email,password:"",password_confirmation:""}),p=()=>{s.post(route("password.update"),{onFinish:()=>s.reset("password","password_confirmation")})};return(S,a)=>(c(),f(v,null,{default:m(()=>[o(e(_),{title:"Reset Password"}),o(x,{class:"mb-4"}),r("form",{onSubmit:b(p,["prevent"])},[r("div",null,[o(i,{for:"email",value:"Email"}),o(l,{id:"email",type:"email",class:"mt-1 block w-full",modelValue:e(s).email,"onUpdate:modelValue":a[0]||(a[0]=t=>e(s).email=t),required:"",autofocus:"",autocomplete:"username"},null,8,["modelValue"])]),r("div",P,[o(i,{for:"password",value:"Password"}),o(l,{id:"password",type:"password",class:"mt-1 block w-full",modelValue:e(s).password,"onUpdate:modelValue":a[1]||(a[1]=t=>e(s).password=t),required:"",autocomplete:"new-password"},null,8,["modelValue"])]),r("div",$,[o(i,{for:"password_confirmation",value:"Confirm Password"}),o(l,{id:"password_confirmation",type:"password",class:"mt-1 block w-full",modelValue:e(s).password_confirmation,"onUpdate:modelValue":a[2]||(a[2]=t=>e(s).password_confirmation=t),required:"",autocomplete:"new-password"},null,8,["modelValue"])]),r("div",g,[o(k,{class:V({"opacity-25":e(s).processing}),disabled:e(s).processing},{default:m(()=>[w(" Reset Password ")]),_:1},8,["class","disabled"])])],40,y)]),_:1}))}};export{h as default};