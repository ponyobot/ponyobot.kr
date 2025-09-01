# 🐟 PonyoBot — Website

- This is the official website of Ponyobot.
- 포뇨봇의 공식 웹사이트입니다.

---

[**🌐 Live Demo / 데모 사이트**](https://ponyobot.kr)

![Preview Image](/images/home.png)

---

## ✨ Features / 주요 기능

- [x] Responsive layout with card‑based service navigation  
  반응형 레이아웃과 카드형 서비스 안내
- [x] KO/EN language switcher (dictionary‑based translations)  
  한/영 전환(`translations` 사전 기반)
- [x] Light / dark / system themes with persistence  
  라이트/다크/시스템 테마 지원 및 저장
- [x] Open Graph metadata & favicon for rich previews  
  Open Graph/파비콘 등 SNS 공유 최적화
- [x] Safe redirect handler (`/redirect`) with KakaoTalk in‑app browser detection  
  KakaoTalk 인앱 브라우저 대응 안전 리다이렉트 페이지
- [x] Developer info & API documentation pages  
  개발자 정보 및 API 문서 페이지

---

## 🚀 Getting Started / 시작하기

1. Clone the repository / 저장소 클론:
   ```sh
   cd ~
   git clone https://github.com/ponyobot/ponyobot.git
   cd ponyobot
   ```
2. Open `ponyobot/index.html` in a browser to view the landing page.  
   `ponyobot/index.html`을 브라우저에서 열어 랜딩 페이지를 확인하세요.
3. Edit `index.html` → `serviceLinks` to customize service links:  
   `index.html`의 `serviceLinks` 값을 수정해 서비스 링크를 변경할 수 있습니다.
   ```js
   const serviceLinks = {
     commands: 'https://blog.ponyobot.kr/posts/cmd',
     blog: 'https://blog.ponyobot.kr',
     status: 'https://status.ponyobot.kr',
     api: '/api/',
     redirect: '/redirect/',
     developer: '/dev/'
   };
   ```
4. To customize SEO metadata, edit `<head>` (`og:title`, `og:description`, `og:image`).  
   SEO 메타데이터를 수정하려면 `<head>`의 `og:title`, `og:description`, `og:image`를 변경하세요.
5. Replace images inside `./ponyobot/images/` to fit your branding.  
   `./ponyobot/images/` 폴더의 이미지를 교체해 브랜딩을 적용하세요.

---

## 🧭 Project Structure / 폴더 구조

```text
ponyobot/
  ├── api/        # API info page / API 정보 페이지
  ├── dev/        # Developer info & contact / 개발자 정보 및 연락처
  ├── images/     # Static assets / 정적 리소스
  └── redirect/   # Safe redirect handler / 안전 리다이렉트 핸들러
```

---

## ⚡ Redirect Usage / 리다이렉트 사용법

```text
#리다이렉트
/redirect/?url=https://example.com

# 멜론 리다이렉트
/redirect/?ID=SONG ID
```

## ✏️ Contributing / 기여하기

Issues and PRs are welcome! For major changes, please open an issue first.  
이슈와 PR은 언제나 환영합니다! 주요 변경사항은 먼저 이슈를 열어주세요.

---

## 📄 License / 라이선스

- This project is licensed under the MIT License.
- 이 프로젝트는 MIT 라이선스에 따라 라이선스가 부여되었습니다.

---
