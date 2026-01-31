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
   ```bash
   ./v db:seed # Populate with initial intent
   ```

3. **PHP Configuration**:
   I have globally enabled `pdo_mysql` and `intl` in `/etc/php/conf.d/`. If things still look "empty," run `valet restart`.

4. **Access UI**:
   Open [http://verdict.test](http://verdict.test).

## Phase 2: Integrations & Enforcement

VERDICT now actively monitors your implementation for "Intent Drift."

### 1. Git Integration
Link your commits to decisions by adding the decision ID in your commit messages:
`[D1] Implementing the flux capacitor`

Sync the ledger with your code:
```bash
./v verdict:sync-git
```

### 2. Architectural Enforcement
VERDICT snapshots the repo structure at decision-time. If you add files without documenting the decision, the system flags it as "undocumented drift."

Run enforcement (perfect for CI/CD):
```bash
./v verdict:enforce --strict
```

## Testing & Verification
Use the provided `./v` (Artisan wrapper) for all operations.

```bash
./v test
```

---
*Built with caffeine, existential dread, and a profound hatred for Jira.*
