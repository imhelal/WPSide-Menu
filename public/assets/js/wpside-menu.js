let wpsm_toggle_btn = document.querySelectorAll('.wpsm-toggle-btn');
let wpsm_item_has_child = document.querySelectorAll('.wpsm-nav .menu-item-has-children');

// If has wpsm menu
if(wpsm_toggle_btn.length > 0) {
    let wpsm_wrapper = document.querySelector('.wpsm-wrapper');
    wpsm_toggle_btn.forEach((item)=>{
        item.addEventListener('click', (e)=>{
            e.preventDefault();
            wpsm_wrapper.classList.toggle('wpsm-open');
        });
    });
}
// If menu has submenu
if(wpsm_item_has_child.length > 0) {
    wpsm_item_has_child.forEach((item)=>{
        console.log('sfsd')
        item.addEventListener('click', ()=>{
            item.classList.toggle('wpsm-submenu-active');
        })
    });
}