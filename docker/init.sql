CREATE TABLE polls(
				id SERIAL PRIMARY KEY,
				uuid VARCHAR(255) NOT NUll,
				title VARCHAR(255) NOT NULL
);

CREATE TABLE options(
				id SERIAL PRIMARY KEY,
				poll_id BIGINT NOT NULL,
				title VARCHAR(255) NOT NUll,
				votes INT NOT NULL DEFAULT 0,
				FOREIGN KEY(poll_id)
								REFERENCES polls(id) ON
												DELETE CASCADE
);
