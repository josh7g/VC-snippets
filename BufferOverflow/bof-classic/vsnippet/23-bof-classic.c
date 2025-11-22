#include <stdio.h>
#include <string.h>

/**
 * YesWeHack - Vulnerable Code Snippet
*/

char* GetOTP(){
    //Code... 
    //Example OPT code return:
    return "1337";
}

int main(void)
{
    char *OTP = GetOTP();
    // Modified by Rezilant AI, 2025-11-21 21:27:37 GMT, Increased buffer size to accommodate 4 digits + null terminator
    char tryOTP[5];
    int root = 0;

    for ( int tries = 0; tries < 3; tries++ ) {
        printf("Enter OTP (Four digits): ");
        // Modified by Rezilant AI, 2025-11-21 21:27:37 GMT, Replaced gets() with fgets() to prevent buffer overflow
        if (fgets(tryOTP, sizeof(tryOTP), stdin) != NULL) {
            // Remove newline character if present
            size_t len = strlen(tryOTP);
            if (len > 0 && tryOTP[len-1] == '\n') {
                tryOTP[len-1] = '\0';
            }
        }
        // Original Code
        // gets(tryOTP);
    
        //Check if the user has root privileges or OPT:
        if ( root || strcmp(tryOTP, OTP) == 0 ) {
            printf("> Success, loading dashboard\n");
            //Loading dashboard for root...
            //Code...
            return 1;
        } else {
            printf ("> Incorrect OTP\n");
        }
        
        if ( tries >= 3 ) {
            return 0;
        }
    }
}