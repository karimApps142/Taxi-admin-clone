import{_ as u}from"./Authenticated.d169710d.js";import{r as _,a as p,o as a,c as o,b as s,d as v,H as h,w as m,F as i,e as t,h as d,t as n}from"./app.cea855f7.js";const f={class:"sm:flex"},g={class:"flex-1 mx-1 my-2 px-2 py-3 rounded"},b={class:"m-1 p-3 rounded border sm:w-60 overflow-auto",style:{height:"calc(100vh - 90px)"}},x=t("p",{class:"font-bold mb-2"},"Views list",-1),y={class:"flex items-center pb-1 border-b w-full"},w={class:"ml-2 font-bold text-xs"},L={class:"m-1 p-3 rounded border sm:w-80 overflow-auto",style:{"max-height":"calc(100vh - 90px)"}},j=t("p",{class:"font-bold mb-2 pb-2 border-b"},"Replies",-1),z={class:"mr-2 mt-1"},k={class:"bg-slate-200 p-3 rounded-lg"},B={class:"font-bold text-sm"},E={class:"text-sm"},M={__name:"StoryDetails",setup(S){const l=_({comments:[{name:"Oliver Sultzer",avatar:"https://randomuser.me/api/portraits/men/1.jpg",comment:`Lorem ipsum dolor, sit amet consectetur adipisicing elit. Eum natus libero
            facilis velit recusandae iure voluptatum aliquam repellendus.`},{name:"Nathan Montgomery",avatar:"https://randomuser.me/api/portraits/men/2.jpg",comment:"Lorem ipsum dolor, sit amet consectetur adipisicing elit."},{name:"Wesley Mills",avatar:"https://randomuser.me/api/portraits/men/3.jpg",comment:"Lorem ipsum dolor."},{name:" Mattie Ford",avatar:"https://randomuser.me/api/portraits/men/4.jpg",comment:"Lorem ipsum dolor. sit amet consectetur"},{name:"Brooklyn Curtis",avatar:"https://randomuser.me/api/portraits/men/5.jpg",comment:"Lorem ipsum"},{name:"Joann Gonzalez",avatar:"https://randomuser.me/api/portraits/men/6.jpg",comment:`Lorem ipsum dolor, sit amet consectetur adipisicing elit. Eum natus libero
            facilis velit recusandae iure voluptatum aliquam`},{name:"Eli Adams",avatar:"https://randomuser.me/api/portraits/men/7.jpg",comment:"Lorem ipsum dolor, sit amet consectetur fasa."}]});return(A,C)=>{const r=p("v-img"),c=p("v-avatar");return a(),o(i,null,[s(v(h),{title:"Reports"}),s(u,{isBack:"",title:"Story Details"},{default:m(()=>[t("section",f,[t("div",g,[s(r,{src:`https://picsum.photos/500/300?image=${4*5+10}`,"lazy-src":`https://picsum.photos/10/6?image=${2*5+10}`},null,8,["src","lazy-src"])]),t("div",null,[t("div",b,[x,(a(!0),o(i,null,d(l.comments,e=>(a(),o("div",{class:"flex mb-2",key:e.name},[t("div",y,[s(c,{size:"30px"},{default:m(()=>[s(r,{alt:"Avatar",src:e.avatar},null,8,["src"])]),_:2},1024),t("p",w,n(e.name),1)])]))),128))])]),t("div",null,[t("div",L,[j,(a(!0),o(i,null,d(l.comments,e=>(a(),o("div",{class:"flex mb-2",key:e.name},[t("div",z,[s(c,{size:"36px"},{default:m(()=>[s(r,{alt:"Avatar",src:e.avatar},null,8,["src"])]),_:2},1024)]),t("div",k,[t("p",B,n(e.name),1),t("p",E,n(e.comment),1)])]))),128))])])])]),_:1})],64)}}};export{M as default};
