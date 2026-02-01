# VERDICT: Cognitive Infrastructure

This is not a task tracker. This is not Jira. If you came here looking for a Kanban board, find the nearest exit.

VERDICT is cognitive infrastructure for engineering governance. It exists to answer, with evidence, why things happened, who decided them, and what risks were knowingly accepted. It is about memory, intent, and accountability.

## Core Philosophy
1. **Decisions are first-class primitives**: Everything else (tasks, incidents, PRs) is a secondary artifact.
2. **Architecture is enforceable intent**: If the system drifts from its declared state, the ledger notices.
3. **Accountability is memory, not punishment**: We log every override and risk acceptance so we don't repeat our collective stupidity.
4. **Systems must remember their own failures**: Retrospectives are manual and flawed. Autopsies are deterministic and immutable.

## System Capabilities

### Phase 1: The Core Engine
- **Immutable Accountability Ledger**: Every decision, status change, and outcome is recorded in a SHA-256 cryptographically chained ledger.
- **Context Snapshots**: Decisions are frozen alongside a JSON snapshot of "reality" (knowns, unknowns, risks, and human energy levels).
- **Rule-based Autopsy Engine**: Automated analysis of outcomes vs. decision-time confidence. Detects "The Arrogance Trap," "Ignored Warnings," and "Blind Spots."

### Phase 1.5: Visual Infrastructure
- **Decision Timeline**: A premium, dark-mode vertical flow of choice and consequence.
- **Context Inspection**: Deep-dive views into decision snapshots and the cryptographic chain.
- **Evidence UI**: Direct visualization of linked code changes and architectural drift.

### Phase 4: Advanced Governance & Intelligence
- **CI/CD Enforcement**: `./v verdict:enforce --strict` ensures every decision has implementation evidence.
- **Cognitive UI**: A premium dark-mode interface for visualizing the architectural timeline.
- **UI Governance**: Replaces CLI commands with a web-based **System Cockpit** for Git Sync, Enforcement, and Ledger Verification.
- **Actor Intelligence**: Tracks the "Wisdom Index" and career trajectories of all architectural actors.

### Phase 2: Implementation & Enforcement
- **Git Linker**: Automatically associates commits with decisions using `[D#]` tags in commit messages.
- **Architectural Hashing**: Snapshots the repository's directory/file structure at decision-time to detect undocumented evolution.
- **Governance Enforcement**: CI/CD ready commands to fail builds if undocumented drift is detected or if architectural changes lack linked intent.

---

## Operations & CLI

Due to local PHP environment constraints, use the provided `./v` wrapper for all commands.

### Engineering Governance
- `verdict:decision`: Interactively document a decision and commit it to the ledger.
- `verdict:outcome {decision_id}`: Record an impact delta (incident, delay, cost).
- `verdict:autopsy {outcome_id}`: Run the deterministic analysis engine on a failure.
- `verdict:verify`: Cryptographically verify the integrity of the entire accountability chain.

### Integration Workflow
- `verdict:sync-git`: Scan git history for `[D#]` links and associate evidence with intent.
- `verdict:enforce`: (CI/CD) Verifies that no undocumented "drift" has occurred since the last decision.

---

## Local Setup: Valet Linux Plus
1. **Link Project**: `valet link verdict`
2. **Setup Data**: `./v db:seed`
3. **Environment**: Ensure `pdo_mysql` and `intl` are enabled (the system should have already handled this via `/etc/php/conf.d/`).
4. **Access**: [http://verdict.test](http://verdict.test)

## Verification
```bash
./v test
```

---
*Built with caffeine, existential dread, and a profound hatred for Jira.*
