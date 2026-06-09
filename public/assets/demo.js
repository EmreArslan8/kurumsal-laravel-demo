document.querySelectorAll('[data-tabs]').forEach((tabs) => {
    const buttons = tabs.querySelectorAll('[data-tab-button]');
    const panels = tabs.querySelectorAll('[data-tab-panel]');

    buttons.forEach((button) => {
        button.addEventListener('click', () => {
            const target = button.dataset.tabButton;

            buttons.forEach((item) => item.classList.toggle('active', item === button));
            panels.forEach((panel) => panel.classList.toggle('active', panel.dataset.tabPanel === target));
        });
    });
});
