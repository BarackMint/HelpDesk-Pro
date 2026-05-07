# Contributing to HelpDesk Pro

Thank you for contributing to HelpDesk Pro. This project follows structured development practices to ensure code quality, consistency, and maintainability.

---

## 📌 Contribution Guidelines

- Follow the defined Git workflow and branch structure  
- Keep commits clear and meaningful  
- Ensure code is clean, readable, and well-structured  
- Do not introduce unnecessary features outside the project scope  
- Test your changes before submitting  

---

## 🔀 Git Workflow

### Branch Structure
- `main` → Production-ready code  
- `develop` → Active development  
- `feature/*` → New features  
- `bugfix/*` → Bug fixes  
- `hotfix/*` → Urgent production fixes  

---

## 🔁 Pull Request Rules

Every pull request must:

- Be created from a dedicated branch (`feature/*`, `bugfix/*`, etc.)  
- Include a clear description of what was changed  
- Include screenshots (if UI changes are involved)  
- Include testing notes (how the feature was tested)  
- Be reviewed before merging  

> No silent commits. Every change must be traceable.

---

## 📝 Commit Convention

This project uses conventional commits for a clean and understandable history.

### Types

- **feat** – A new feature  
  _Example:_ `feat: add ticket creation`

- **fix** – A bug fix  
  _Example:_ `fix: resolve ticket status update issue`

- **refactor** – Code restructuring without changing behavior  
  _Example:_ `refactor: move logic to service class`

- **chore** – Maintenance tasks  
  _Example:_ `chore: update dependencies`

- **docs** – Documentation changes  
  _Example:_ `docs: update README`

- **style** – Code formatting only (no logic changes)  
  _Example:_ `style: format code`

- **test** – Adding or updating tests  
  _Example:_ `test: add ticket feature tests`

- **perf** – Performance improvements  
  _Example:_ `perf: optimize ticket queries`

- **build** – Build system or dependency changes  
  _Example:_ `build: update composer config`

- **ci** – Continuous integration changes  
  _Example:_ `ci: update workflow`

- **revert** – Reverting previous commits  
  _Example:_ `revert: undo ticket assignment feature`

---

## 📂 Code Standards

- Follow Laravel MVC architecture  
- Keep controllers thin (no heavy logic)  
- Use proper naming conventions  
- Validate all user inputs  
- Maintain consistent coding style throughout the project  

---

## 🔐 Security & Validation

- Always validate inputs  
- Enforce role-based access control  
- Prevent unauthorized actions (e.g., users accessing others’ tickets)  

---

## 🧪 Testing

Before submitting changes:

- Test the feature manually  
- Ensure no existing functionality is broken  
- Verify role-based behavior (User, Agent, Admin)  

---

## 🚫 What to Avoid

- Mixing multiple features in one branch  
- Large, unclear commits  
- Skipping validation or authorization checks  
- Adding features outside defined requirements  

---

## 🎯 Goal

Maintain a clean, scalable, and professional codebase that reflects real-world development practices.
