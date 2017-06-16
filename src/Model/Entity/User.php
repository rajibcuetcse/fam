<?php
namespace App\Model\Entity;

use App\Auth\CmsPasswordHasher;
use Cake\ORM\Entity;

/**
 * User Entity.
 *
 * @property int $id
 * @property string $nickname
 * @property int $user_type
 * @property int $registration_type
 * @property string $social_id
 * @property \App\Model\Entity\Social $social
 * @property string $email
 * @property string $password
 * @property string $pre_lang
 * @property \Cake\I18n\Time $date_of_birth
 * @property string $profile_pic_url
 * @property string $api_token
 * @property \Cake\I18n\Time $api_token_expired_on
 * @property string $is_rec_marketing_email
 * @property string $is_verified
 * @property int $profile_pic_modify_time
 * @property int $balance_stars
 * @property int $balance_tickets
 * @property int $balance_tokens
 * @property int $unlocking_ability
 * @property \Cake\I18n\Time $created_on
 * @property \Cake\I18n\Time $updated_on
 * @property \App\Model\Entity\ApiToken[] $api_tokens
 * @property \App\Model\Entity\Collection[] $collections
 * @property \App\Model\Entity\ContentCommentLike[] $content_comment_likes
 * @property \App\Model\Entity\ContentCommentReport[] $content_comment_reports
 * @property \App\Model\Entity\ContentComment[] $content_comments
 * @property \App\Model\Entity\ContentCommentsCopy[] $content_comments_copy
 * @property \App\Model\Entity\ContentLike[] $content_likes
 * @property \App\Model\Entity\FriendInvitation[] $friend_invitations
 * @property \App\Model\Entity\LogEvent[] $log_events
 * @property \App\Model\Entity\PaymentReceipt[] $payment_receipts
 * @property \App\Model\Entity\StarActivity[] $star_activities
 * @property \App\Model\Entity\TokenTransaction[] $token_transactions
 * @property \App\Model\Entity\UnlockingAbilityChangeHistory[] $unlocking_ability_change_histories
 * @property \App\Model\Entity\UnlockingActivity[] $unlocking_activities
 */
class User extends Entity
{

    /**
     * Fields that can be mass assigned using newEntity() or patchEntity().
     *
     * Note that when '*' is set to true, this allows all unspecified fields to
     * be mass assigned. For security purposes, it is advised to set '*' to false
     * (or remove it), and explicitly make individual fields accessible as needed.
     *
     * @var array
     */
    protected $_accessible = [
        '*' => true,
        'id' => false,
    ];

    protected function _setPassword($value)
    {
        $hasher = new CmsPasswordHasher();
        return $hasher->hash($value);
    }
}
