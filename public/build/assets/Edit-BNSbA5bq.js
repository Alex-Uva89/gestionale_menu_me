import{A as S}from"./ApplicationLogo-DsQX7Urj.js";import{D as B,E,h as v,B as L,o as l,f as h,b as e,r as c,i as $,A as k,a as o,w as a,n as u,G as D,c as b,u as p,j as _,d,t as y,g as M,F as N,Z as V}from"./app-H1OgYtxl.js";import j from"./DeleteUserForm-l3iu_Wqs.js";import z from"./UpdatePasswordForm-dZ54QTRv.js";import A from"./UpdateProfileInformationForm-Jn1c3fNN.js";import"./_plugin-vue_export-helper-DlAUqK2U.js";import"./TextInput-CMFkFBDZ.js";import"./Modal-mA81x3nk.js";import"./PrimaryButton-CYKeWhZD.js";const P={class:"relative"},q={__name:"Dropdown",props:{align:{type:String,default:"right"},width:{type:String,default:"48"},contentClasses:{type:String,default:"py-1 bg-white"}},setup(r){const s=r,t=g=>{i.value&&g.key==="Escape"&&(i.value=!1)};B(()=>document.addEventListener("keydown",t)),E(()=>document.removeEventListener("keydown",t));const n=v(()=>({48:"w-48"})[s.width.toString()]),m=v(()=>s.align==="left"?"ltr:origin-top-left rtl:origin-top-right start-0":s.align==="right"?"ltr:origin-top-right rtl:origin-top-left end-0":"origin-top"),i=L(!1);return(g,f)=>(l(),h("div",P,[e("div",{onClick:f[0]||(f[0]=w=>i.value=!i.value)},[c(g.$slots,"trigger")]),$(e("div",{class:"fixed inset-0 z-40",onClick:f[1]||(f[1]=w=>i.value=!1)},null,512),[[k,i.value]]),o(D,{"enter-active-class":"transition ease-out duration-200","enter-from-class":"opacity-0 scale-95","enter-to-class":"opacity-100 scale-100","leave-active-class":"transition ease-in duration-75","leave-from-class":"opacity-100 scale-100","leave-to-class":"opacity-0 scale-95"},{default:a(()=>[$(e("div",{class:u(["absolute z-50 mt-2 rounded-md shadow-lg w-full",[n.value,m.value]]),style:{display:"none"},onClick:f[2]||(f[2]=w=>i.value=!1)},[e("div",{class:u(["rounded-md ring-1 ring-black ring-opacity-5 w-full",r.contentClasses])},[c(g.$slots,"content")],2)],2),[[k,i.value]])]),_:3})]))}},C={__name:"DropdownLink",props:{href:{type:String,required:!0}},setup(r){return(s,t)=>(l(),b(p(_),{href:r.href,class:"block w-full px-4 py-2 text-start text-sm leading-5 text-gray-700 hover:bg-gray-100 focus:outline-none focus:bg-gray-100 transition duration-150 ease-in-out"},{default:a(()=>[c(s.$slots,"default")]),_:3},8,["href"]))}},O={__name:"NavLink",props:{href:{type:String,required:!0},active:{type:Boolean}},setup(r){const s=r,t=v(()=>s.active?"inline-flex items-center px-1 pt-1 border-b-2 border-indigo-400 text-sm font-medium leading-5 text-gray-900 focus:outline-none focus:border-indigo-700 transition duration-150 ease-in-out":"inline-flex items-center px-1 pt-1 border-b-2 border-transparent text-sm font-medium leading-5 text-gray-500 hover:text-gray-700 hover:border-gray-300 focus:outline-none focus:text-gray-700 focus:border-gray-300 transition duration-150 ease-in-out");return(n,m)=>(l(),b(p(_),{href:r.href,class:u(t.value)},{default:a(()=>[c(n.$slots,"default")]),_:3},8,["href","class"]))}},x={__name:"ResponsiveNavLink",props:{href:{type:String,required:!0},active:{type:Boolean}},setup(r){const s=r,t=v(()=>s.active?"block w-full ps-3 pe-4 py-2 border-l-4 border-indigo-400 text-start text-base font-medium text-indigo-700 bg-indigo-50 focus:outline-none focus:text-indigo-800 focus:bg-indigo-100 focus:border-indigo-700 transition duration-150 ease-in-out":"block w-full ps-3 pe-4 py-2 border-l-4 border-transparent text-start text-base font-medium text-gray-600 hover:text-gray-800 hover:bg-gray-50 hover:border-gray-300 focus:outline-none focus:text-gray-800 focus:bg-gray-50 focus:border-gray-300 transition duration-150 ease-in-out");return(n,m)=>(l(),b(p(_),{href:r.href,class:u(t.value)},{default:a(()=>[c(n.$slots,"default")]),_:3},8,["href","class"]))}},F={class:"min-h-screen bg-gray-100"},T={class:"bg-white border-b border-gray-100"},G={class:"max-w-7xl mx-auto px-4 sm:px-6 lg:px-8"},R={class:"flex justify-between h-16"},U={class:"flex"},Z={class:"shrink-0 flex items-center"},H={class:"hidden space-x-8 sm:-my-px sm:ms-10 sm:flex"},I={class:"hidden sm:flex sm:items-center sm:ms-6"},J={class:"ms-3 relative"},K={class:"inline-flex rounded-md"},Q={type:"button",class:"inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-gray-500 bg-white hover:text-gray-700 focus:outline-none transition ease-in-out duration-150"},W=e("svg",{class:"ms-2 -me-0.5 h-4 w-4",xmlns:"https://www.w3.org/2000/svg",viewBox:"0 0 20 20",fill:"currentColor"},[e("path",{"fill-rule":"evenodd",d:"M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z","clip-rule":"evenodd"})],-1),X={class:"-me-2 flex items-center sm:hidden"},Y={class:"h-6 w-6",stroke:"currentColor",fill:"none",viewBox:"0 0 24 24"},ee={class:"pt-2 pb-3 space-y-1"},te={class:"pt-4 pb-1 border-t border-gray-200"},se={class:"px-4"},oe={class:"font-medium text-base text-gray-800"},ae={class:"font-medium text-sm text-gray-500"},re={class:"mt-3 space-y-1"},ne={key:0,class:"bg-white shadow"},ie={class:"max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8"},le={__name:"AuthenticatedLayout",setup(r){const s=L(!1);return(t,n)=>(l(),h("div",null,[e("div",F,[e("nav",T,[e("div",G,[e("div",R,[e("div",U,[e("div",Z,[o(p(_),{href:t.route("dashboard")},{default:a(()=>[o(S,{class:"block h-9 w-auto fill-current text-gray-800"})]),_:1},8,["href"])]),e("div",H,[o(O,{href:t.route("dashboard"),active:t.route().current("dashboard")},{default:a(()=>[d(" Dashboard ")]),_:1},8,["href","active"])])]),e("div",I,[e("div",J,[o(q,{align:"right",width:"48"},{trigger:a(()=>[e("span",K,[e("button",Q,[d(y(t.$page.props.auth.user.name)+" ",1),W])])]),content:a(()=>[o(C,{href:t.route("profile.edit")},{default:a(()=>[d(" Profile ")]),_:1},8,["href"]),o(C,{href:t.route("logout"),method:"post",as:"button"},{default:a(()=>[d(" Log Out ")]),_:1},8,["href"])]),_:1})])]),e("div",X,[e("button",{onClick:n[0]||(n[0]=m=>s.value=!s.value),class:"inline-flex items-center justify-center p-2 rounded-md text-gray-400 hover:text-gray-500 hover:bg-gray-100 focus:outline-none focus:bg-gray-100 focus:text-gray-500 transition duration-150 ease-in-out"},[(l(),h("svg",Y,[e("path",{class:u({hidden:s.value,"inline-flex":!s.value}),"stroke-linecap":"round","stroke-linejoin":"round","stroke-width":"2",d:"M4 6h16M4 12h16M4 18h16"},null,2),e("path",{class:u({hidden:!s.value,"inline-flex":s.value}),"stroke-linecap":"round","stroke-linejoin":"round","stroke-width":"2",d:"M6 18L18 6M6 6l12 12"},null,2)]))])])])]),e("div",{class:u([{block:s.value,hidden:!s.value},"sm:hidden"])},[e("div",ee,[o(x,{href:t.route("dashboard"),active:t.route().current("dashboard")},{default:a(()=>[d(" Dashboard ")]),_:1},8,["href","active"])]),e("div",te,[e("div",se,[e("div",oe,y(t.$page.props.auth.user.name),1),e("div",ae,y(t.$page.props.auth.user.email),1)]),e("div",re,[o(x,{href:t.route("profile.edit")},{default:a(()=>[d(" Profile ")]),_:1},8,["href"]),o(x,{href:t.route("logout"),method:"post",as:"button"},{default:a(()=>[d(" Log Out ")]),_:1},8,["href"])])])],2)]),t.$slots.header?(l(),h("header",ne,[e("div",ie,[c(t.$slots,"header")])])):M("",!0),e("main",null,[c(t.$slots,"default")])])]))}},de=e("h2",{class:"font-semibold text-xl text-gray-800 leading-tight"},"Profile",-1),ue={class:"py-12"},ce={class:"max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6"},fe={class:"p-4 sm:p-8 bg-white shadow sm:rounded-lg"},he={class:"p-4 sm:p-8 bg-white shadow sm:rounded-lg"},pe={class:"p-4 sm:p-8 bg-white shadow sm:rounded-lg"},ke={__name:"Edit",props:{mustVerifyEmail:{type:Boolean},status:{type:String}},setup(r){return(s,t)=>(l(),h(N,null,[o(p(V),{title:"Profile"}),o(le,null,{header:a(()=>[de]),default:a(()=>[e("div",ue,[e("div",ce,[e("div",fe,[o(A,{"must-verify-email":r.mustVerifyEmail,status:r.status,class:"max-w-xl"},null,8,["must-verify-email","status"])]),e("div",he,[o(z,{class:"max-w-xl"})]),e("div",pe,[o(j,{class:"max-w-xl"})])])])]),_:1})],64))}};export{ke as default};
//# sourceMappingURL=Edit-BNSbA5bq.js.map