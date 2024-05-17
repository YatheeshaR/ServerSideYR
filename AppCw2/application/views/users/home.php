<?php include_once('header.php'); ?>
    <h2>
        Welcome <?php echo $this->session->userdata('fullname'); ?>
    </h2>
    <hr/>
    
    <div class="row">
        <div class="col-lg-12 col-md-12">
            <h4>Your Top Answers</h4>
            <br/>
            <div style="height:350px;overflow:auto" class="table-responsive">
                <table class="table">
                    <tr>
                        <th>Sno.</th>
                        <th>Answers</th>
                        <th>Likes</th>
                        <th>Dislikes</th>
                        <th>Question</th>
                    </tr>
                    <?php $i=1; foreach($top_answers as $a): ?>
                    <tr>
                        <th><?= $i++; ?></th>
                        <th><?= $a->answer ?></th>
                        <th><?= $a->likes ?></th>
                        <th><?= $a->dislikes ?></th>
                        <th>
                            <a target="_blank" class="btn btn-primary" href="<?= base_url('questions/viewquestion/').$a->question_id; ?>">View Question</a>
                        </th>
                        <th>
                            <a class="btn btn-danger" href="<?= base_url('users/deleteanswer/').$a->answer_id; ?>">Delete Answer</a>
                        </th>
                    </tr>
                    <?php endforeach ?>
                </table>
            </div>
        </div>
    </div>
<?php include_once('footer.php'); ?>