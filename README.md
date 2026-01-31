# VERDICT

This is not a task tracker. This is not Jira. If you came here looking for a Kanban board, find the nearest exit.

VERDICT is cognitive infrastructure for engineering governance. It exists to answer, with evidence, why things happened, who decided them, and what risks were knowingly accepted. It is about memory, intent, and accountability.

## Core Philosophy
1. **Decisions are first-class primitives**: Everything else (tasks, incidents, PRs) is a secondary artifact.
2. **Architecture is enforceable intent**: If the system drifts from its declared state, the ledger notices.
3. **Accountability is memory, not punishment**: We log every override and risk acceptance so we don't repeat our collective stupidity.
4. **Systems must remember their own failures**: Retrospectives are manual and flawed. Autopsies are deterministic and immutable.

## Phase 1 Implementation: The Core Engine
We have successfully implemented the skeletal structure of the system:
- **Relational Persistence**: Decisions, Context Snapshots, Actors, and Outcomes.
- **Immutable Accountability Ledger**: Every action is recorded in an append-only chain.
- **SHA-256 Hash Chaining**: Each ledger entry is cryptographically linked to the previous one. Integrity is verifiable.
- **Rule-based Autopsy Engine**: Automated analysis of outcomes vs. decision-time confidence and ignored objections.

## Running the Infrastructure

Due to the "creative" constraints of local PHP environments (missing default drivers), a wrapper script `./v` is provided to inject the necessary MySQL extensions.

### Manual Decision Entry
To document a decision and commit it to the immutable ledger:
```bash
./v verdict:decision
```

### Recording Outcomes
When reality hits and things break (or succeed):
```bash
./v verdict:outcome {decision_id}
```

### Running Autopsies
To generate a rule-based report on why an outcome sucked:
```bash
./v verdict:autopsy {outcome_id}
```

### Verifying Ledger Integrity
To ensure no one has tampered with the historical records:
```bash
./v verdict:verify
```

## Environment Setup: Valet Linux Plus

To host VERDICT locally using Valet Linux Plus:

1. **Link the Project**:
   ```bash
   valet link verdict
   ```

2. **Database Provisioning**:
   If you haven't already:
   ```bash
   valet db:create verdict
   valet db:create verdict_test
   ```

3. **PHP Configuration**:
   Ensure `pdo_mysql` is enabled in your Valet-managed PHP version. If you encounter "driver not found" errors in the browser, check your `php.ini` via `valet use php@8.x` (or your current version).

4. **Access UI**:
   Open [http://verdict.test](http://verdict.test) in your browser.

## Testing & Verification
Direct testing is conducted via the provided `./v` (Artisan wrapper). 

```bash
./v test
```

---
*Built with caffeine, existential dread, and a profound hatred for Jira.*
