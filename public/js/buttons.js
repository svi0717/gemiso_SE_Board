function createButton(text, url) {
    const button = document.createElement('button');
    button.textContent = text;
    button.onclick = function() {
        location.href = url;
    };
     // 버튼 스타일 설정
     button.style.padding = '10px 20px';
     button.style.fontSize = '20px';
     button.style.cursor = 'pointer';
     button.style.backgroundColor = '#2BA8E0'; // 버튼 배경 색상
     button.style.color = '#fff'; // 버튼 글자 색상
     button.style.border = 'none';
     button.style.borderRadius = '5px'; // 버튼 모서리 둥글게
     button.style.transition = 'background-color 0.3s ease';
     button.style.width = '60%';
     button.style.marginBottom = '20px';

     // 버튼에 마우스를 올렸을 때 스타일
     button.onmouseover = function() {
         button.style.backgroundColor = '#1E8AC0'; // 호버 시 배경 색상
     };
     button.onmouseout = function() {
         button.style.backgroundColor = '#2BA8E0'; // 원래 색상으로 복귀
     };
    return button;
}

function addButtonsToPage() {
    const sidebtn = document.getElementById('sidebar-button');
    const boardbtn = document.getElementById('list-buttons');

    const boardButton = createButton('게시판', '/boardList');
    const scheduleButton = createButton('일정관리', '/schedule');
    // const listButton = createButton('목록','/');
    // const editButton = createButton('수정','/editboard');
    // const deleteButton = createButton('삭제','/deleteboard');

    sidebtn.appendChild(boardButton);
    sidebtn.appendChild(document.createElement('br'));
    sidebtn.appendChild(scheduleButton);

    // boardbtn.appendChild(deleteButton);
    // boardbtn.appendChild(editButton);
    // boardbtn.appendChild(listButton);
}
