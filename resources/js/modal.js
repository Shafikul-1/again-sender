let otherLinksData = [];
let linkIndex = 0;
const modal = document.querySelector('.modal');

window.hideModal = function () {
    modal.classList.add('hidden')
}

window.showModal = function () {
    modal.classList.add('flex');
    modal.classList.remove('hidden');
}

window.addLinks = function () {
    let otherLinksContainer = document.querySelector('.otherLinks');
    const iconLink = document.querySelector('input[other-icon-link="iconlink"]');
    const yourLink = document.querySelector('input[other-acc-link="yourlink"]');
    otherLinksContainer.innerHTML += `
        <div class="relative rounded-full border p-3 dark:border-white" data-index="${linkIndex}">
            <i class="fa fa-solid fa-xmark absolute top-[-15px] right-0 dark:text-white cursor-pointer" onclick="otherIconRemove(this)"></i>
            <a href="${yourLink.value}">
                <img width="25px" src="${iconLink.value}" alt="">
            </a>
        </div>
    `;

    const other_data = {
        yourLink: yourLink.value,
        iconLink: iconLink.value,
        linkIndex: linkIndex // Add index to the object
    };

    otherLinksData.push(other_data);
    linkIndex++;

    modal.classList.add('hidden');
    iconLink.value = '';
    yourLink.value = '';
}

document.querySelector('.submitForm').addEventListener('submit', function (e) {
    const otherLinksDataField = document.getElementById('otherLinksArray');
    otherLinksDataField.value = JSON.stringify(otherLinksData);
});

window.otherIconRemove = function (element) {
    const parentElement = element.parentElement;
    const dataIndex = Number(parentElement.getAttribute('data-index'));
    otherLinksData = otherLinksData.filter(item => item.linkIndex !== dataIndex);
    parentElement.remove();
}
