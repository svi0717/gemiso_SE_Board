<!DOCTYPE html>
<html lang="ko">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>게시판 글쓰기</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
            padding: 0;
        }
        .container {
            max-width: 800px;
            margin: 0 auto;
        }
        form {
            border: 1px solid #ccc;
            padding: 20px;
            background-color: #f9f9f9;
            border-radius: 5px;
        }
        .form-row {
            display: flex;
            align-items: center;
            margin-bottom: 15px;
        }
        .form-row label {
            flex: 0 0 80px; /* 레이블의 고정 너비를 설정 */
            font-weight: bold;
        }
        .form-row input[type="text"] {
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 4px;
            box-sizing: border-box;
        }
        .form-row .title-input {
            flex: 1; /* 제목 입력란이 가능한 공간을 차지하도록 설정 */
            margin-right: 10px; /* 작성자 입력란과의 간격 설정 */
        }
        .form-row .author-input {
            flex: 0.75; /* 작성자 입력란의 너비를 제목 입력란보다 좁게 설정 */
        }
        .form-row textarea {
            width: 100%;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 4px;
            box-sizing: border-box;
        }
        .form-row .submit-container {
            display: flex;
            justify-content: flex-end; /* 제출 버튼을 오른쪽으로 정렬 */
        }
        .submit-button {
            background-color: #4CAF50;
            color: white;
            border: none;
            padding: 15px 20px;
            text-align: center;
            text-decoration: none;
            font-size: 16px;
            cursor: pointer;
            border-radius: 4px;
        }
        .submit-button:hover {
            background-color: #45a049; /* 제출 버튼에 마우스 오버 시 색상 변화 */
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>게시판 글쓰기</h1>
        <form action="/submit-post" method="POST">
            <div class="form-row">
                <label for="title">제목:</label>
                <input type="text" id="title" name="title" required class="title-input">
                <label for="author">작성자:</label>
                <input type="text" id="author" name="author" required class="author-input">
            </div>
            <div class="form-row">
                <label for="content">내용:</label>
                <textarea id="content" name="content" rows="10" required></textarea>
            </div>
            <div class="form-row submit-container">
                <input type="submit" value="작성하기" class="submit-button">
            </div>
        </form>
    </div>
</body>
</html>
