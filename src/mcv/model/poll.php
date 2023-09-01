<?php

namespace Josafast\Polls\model;

use Josafast\Polls\model\Database;
use PDO;
use Exception;

class Poll extends Database
{
	public string $uuid;
	protected int $id;
	public string $title;

	public function __construct(string $uuid = "")
	{
		parent::__construct();
		if (!$uuid) {
			$this->uuid = uniqid();
		} else {
			$query = $this->connect()->prepare("SELECT * FROM polls WHERE uuid=:uuid");
			$query->execute([':uuid' => $uuid]);

			if ($query->rowCount() < 1) {
				throw new Exception('Objeto no encontrado');
			} else {
				$pollFetch = $query->fetch(PDO::FETCH_OBJ);
				$this->title = $pollFetch->title;
				$this->id = $pollFetch->id;
				$this->uuid = $pollFetch->uuid;
			}
		}
	}

	public function save()
	{
		$query = $this->connect()->prepare("SELECT * FROM polls WHERE uuid = :uuid");
		$query->execute([":uuid" => $this->uuid]);
		$dontExistingPoll = $query->rowCount() < 1;

		$sql = $dontExistingPoll ? "INSERT INTO polls(uuid, title) VALUES (:uuid, :title) RETURNING id;" : "UPDATE polls SET title=:title WHERE uuid=:uuid RETURNING id";
		$query = $this->connect()->prepare($sql);
		$query->execute([":uuid" => $this->uuid, ":title" => $this->title]);
		$this->id = $query->fetch()['id'];
	}

	public function setOptions(array $options)
	{
		$query = $this->connect()->prepare("SELECT * FROM options WHERE poll_id = :poll_id");
		$query->execute([":poll_id" => $this->id]);
		$sql = "INSERT INTO options(poll_id, title) VALUES (:poll_id, :title)";

		if ($query->rowCount() >= 1) {
			$deletedOptions = $this->connect()->prepare("DELETE FROM options WHERE poll_id = :poll_id");
			$deletedOptions->execute([':poll_id' => $this->id]);
		}
		$transactionBeginner = $this->connect();
		$query = $transactionBeginner->prepare($sql);
		$transactionBeginner->beginTransaction();
		foreach ($options as $option) {
			$query->execute([":poll_id" => $this->id, ":title" => $option]);
		}
		$transactionBeginner->commit();
	}

	public function voteInOption(string $vote_option): void
	{
		$query = $this->connect()->prepare("UPDATE options SET votes = votes+1 WHERE poll_id = :poll_id AND title = :title");
		$query->execute([':poll_id' => $this->id, ':title' => $vote_option]);
	}

	public function getOptions(): array
	{
		$query = $this->connect()->prepare("SELECT *, (SELECT SUM(votes) FROM options WHERE poll_id=:poll_id) FROM options WHERE poll_id = :poll_id");
		$query->execute([':poll_id' => $this->id]);

		return $query->fetchAll(PDO::FETCH_OBJ);
	}

	public static function getPolls()
	{
		$db = new Database();
		$polls = $db->connect()->query("SELECT * FROM polls");

		return $polls;
	}

	public static function delete(string $uuid): void
	{
		$db = new Database();
		$query = $db->connect()->prepare("DELETE FROM polls WHERE uuid=:uuid");
		$query->execute([':uuid' => $uuid]);
	}
}
