function startApp(){showPassword()}function showPassword(){const t=document.getElementById("mostrar"),e=document.getElementById("password"),n=document.getElementById("mostrar2"),s=document.getElementById("password2");s.addEventListener("input",()=>{0===s.value.length?n.classList.remove("container-auth__btn-password--mostrar"):n.classList.add("container-auth__btn-password--mostrar")}),n.addEventListener("click",()=>{"password"===s.type?(s.type="text",n.textContent="Hidden"):(s.type="password",n.textContent="Show")}),e.addEventListener("input",()=>{0===e.value.length?t.classList.remove("container-auth__btn-password--mostrar"):t.classList.add("container-auth__btn-password--mostrar")}),t.addEventListener("click",()=>{"password"===e.type?(e.type="text",t.textContent="Hidden"):(e.type="password",t.textContent="Show")})}document.addEventListener("DOMContentLoaded",(function(){startApp()}));
//# sourceMappingURL=password.js.map
